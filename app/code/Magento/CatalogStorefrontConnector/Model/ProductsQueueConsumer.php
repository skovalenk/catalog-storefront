<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\CatalogStorefrontConnector\Model;

use Magento\CatalogExport\Model\ChangedEntitiesMessageBuilder;
use Magento\CatalogMessageBroker\Model\MessageBus\Product\ProductsConsumer;
use Magento\CatalogStorefrontConnector\Helper\CustomStoreResolver;
use Magento\CatalogStorefrontConnector\Model\Data\UpdatedEntitiesDataInterface;
use Magento\CatalogStorefrontConnector\Model\Publisher\CatalogEntityIdsProvider;
use Magento\DataExporter\Model\FeedPool;
use Magento\DataExporter\Model\Indexer\FeedIndexer;
use Psr\Log\LoggerInterface;

/**
 * Consumer processes messages with store front products data
 * @deprecared https://github.com/magento/catalog-storefront/issues/242
 */
class ProductsQueueConsumer
{
    const BATCH_SIZE = 100;

    /**
     * @var CatalogEntityIdsProvider
     */
    private $catalogEntityIdsProvider;

    /**
     * @var ProductsConsumer
     */
    private $productsConsumer;

    /**
     * @var FeedIndexer
     */
    private $productFeedIndexer;

    /**
     * @var ChangedEntitiesMessageBuilder
     */
    private $messageBuilder;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var CustomStoreResolver
     */
    private $storeResolver;
    /**
     * @var FeedPool
     */
    private $feedPool;

    /**
     * @param ProductsConsumer $productsConsumer
     * @param FeedIndexer $productFeedIndexer
     * @param ChangedEntitiesMessageBuilder $messageBuilder
     * @param CustomStoreResolver $storeResolver
     * @param LoggerInterface $logger
     * @param FeedPool $feedPool
     * @param CatalogEntityIdsProvider $catalogEntityIdsProvider
     */
    public function __construct(
        ProductsConsumer $productsConsumer,
        FeedIndexer $productFeedIndexer,
        ChangedEntitiesMessageBuilder $messageBuilder,
        CustomStoreResolver $storeResolver,
        LoggerInterface $logger,
        FeedPool $feedPool,
        CatalogEntityIdsProvider $catalogEntityIdsProvider
    ) {
        $this->catalogEntityIdsProvider = $catalogEntityIdsProvider;
        $this->productsConsumer = $productsConsumer;
        $this->productFeedIndexer = $productFeedIndexer;
        $this->messageBuilder = $messageBuilder;
        $this->logger = $logger;
        $this->storeResolver = $storeResolver;
        $this->feedPool = $feedPool;
    }

    /**
     * Process collected product IDs for update/delete
     *
     * @param UpdatedEntitiesDataInterface $message
     * @return void
     * @deprecated React on events triggered by plugins to push data to SF storage
     */
    public function processMessages(UpdatedEntitiesDataInterface $message): void
    {
        try {
            $storeId = $message->getStoreId();
            $storeCode = $this->storeResolver->resolveStoreCode($storeId);
            $ids = $message->getEntityIds();

            //TODO: remove ad-hoc solution after moving events to corresponding export service
            if (empty($ids)) {
                $this->productFeedIndexer->executeFull();
                foreach ($this->catalogEntityIdsProvider->getProductIds($storeId) as $idsChunk) {
                    $ids[] = $idsChunk;
                }
                $ids = \array_merge(...$ids);
            } else {
                //TODO: move this to plugins?
                $this->productFeedIndexer->executeList($ids);
            }

            $deletedIds = [];
            $productsFeed = $this->feedPool->getFeed('products');
            foreach ($productsFeed->getDeletedByIds($ids, array_filter([$storeCode])) as $product) {
                $deletedIds[] = $product['productId'];
                unset($ids[$product['productId']]);
            }

            $productsArray = $this->buildMessageEntitiesArray($ids);
            $deletedArray = $this->buildMessageEntitiesArray($deletedIds);

            if (!empty($productsArray)) {
                $this->passMessage(
                    ProductsConsumer::PRODUCTS_UPDATED_EVENT_TYPE,
                    $productsArray,
                    $storeCode
                );
            }

            if (!empty($deletedArray)) {
                $this->passMessage(
                    ProductsConsumer::PRODUCTS_DELETED_EVENT_TYPE,
                    $deletedArray,
                    $storeCode
                );
            }
        } catch (\Throwable $e) {
            $this->logger->critical('Unable to process collected product data for update/delete. ' . $e->getMessage());
        }
    }

    /**
     * Build message entities array
     *
     * @param array $entityIds
     *
     * @return array
     */
    private function buildMessageEntitiesArray(array $entityIds): array
    {
        $entitiesArray = [];
        foreach ($entityIds as $id) {
            $entitiesArray[] = [
                'entity_id' => (int)$id,
            ];
        }

        return $entitiesArray;
    }

    /**
     * Publish deleted or updated message
     *
     * @param string $eventType
     * @param array $products
     * @param string $storeCode
     *
     * @return void
     */
    private function passMessage(string $eventType, array $products, string $storeCode): void
    {
        foreach (array_chunk($products, self::BATCH_SIZE) as $chunk) {
            $message = $this->messageBuilder->build(
                $eventType,
                $chunk,
                $storeCode
            );
            try {
                $this->productsConsumer->processMessage($message);
            } catch (\Exception $e) {
                $this->logger->critical($e);
            }
        }
    }
}
