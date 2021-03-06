<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\CatalogStorefrontConnector\Command;

use Magento\CatalogExport\Model\ChangedEntitiesMessageBuilder;
use Magento\CatalogMessageBroker\Model\MessageBus\Category\CategoriesConsumer;
use Magento\CatalogMessageBroker\Model\MessageBus\Product\ProductsConsumer;
use Magento\CatalogStorefrontConnector\Model\Publisher\CatalogEntityIdsProvider;
use Magento\DataExporter\Model\FeedPool;
use Magento\DataExporter\Model\Indexer\FeedIndexer;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Sync Catalog data with Storefront storage. Collect product data and push it to the Message Bus
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * TODO: remove dependencies on Export API repo https://github.com/magento/catalog-storefront/issues/43
 */
class Sync extends Command
{
    /**
     * Command name
     * @var string
     */
    private const COMMAND_NAME = 'storefront:catalog:sync';

    /**
     * Option name for batch size
     * @var string
     */
    private const INPUT_ENTITY_TYPE = 'entity';

    /**
     * Product entity type
     */
    private const ENTITY_TYPE_PRODUCT = 'product';

    /**
     * Category entity type
     */
    private const ENTITY_TYPE_CATEGORY = 'category';

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CatalogEntityIdsProvider
     */
    private $catalogEntityIdsProvider;

    /**
     * @var FeedIndexer
     */
    private $productFeedIndexer;

    /**
     * @var CategoriesConsumer
     */
    private $categoriesConsumer;

    /**
     * @var FeedIndexer
     */
    private $categoryFeedIndexer;

    /**
     * @var FeedPool
     */
    private $feedPool;

    /**
     * @var ChangedEntitiesMessageBuilder
     */
    private $messageBuilder;

    /**
     * @var ProductsConsumer
     */
    private $productsConsumer;

    /**
     * @param StoreManagerInterface $storeManager
     * @param CatalogEntityIdsProvider $catalogEntityIdsProvider
     * @param CategoriesConsumer $categoriesConsumer
     * @param ProductsConsumer $productsConsumer
     * @param FeedIndexer $productFeedIndexer
     * @param FeedIndexer $categoryFeedIndexer
     * @param FeedPool $feedPool
     * @param ChangedEntitiesMessageBuilder $messageBuilder
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        CatalogEntityIdsProvider $catalogEntityIdsProvider,
        CategoriesConsumer $categoriesConsumer,
        ProductsConsumer $productsConsumer,
        FeedIndexer $productFeedIndexer,
        FeedIndexer $categoryFeedIndexer,
        FeedPool $feedPool,
        ChangedEntitiesMessageBuilder $messageBuilder
    ) {
        parent::__construct();

        $this->storeManager = $storeManager;
        $this->catalogEntityIdsProvider = $catalogEntityIdsProvider;
        $this->productFeedIndexer = $productFeedIndexer;
        $this->categoriesConsumer = $categoriesConsumer;
        $this->categoryFeedIndexer = $categoryFeedIndexer;
        $this->feedPool = $feedPool;
        $this->messageBuilder = $messageBuilder;
        $this->productsConsumer = $productsConsumer;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('Run full reindex for Catalog Storefront service')
            ->addOption(
                self::INPUT_ENTITY_TYPE,
                null,
                InputOption::VALUE_OPTIONAL,
                'Entity type code for process. Possible values: product, category. '
                . 'By default all entities will be processed'
            );

        parent::configure();
    }

    /**
     * Sync between Magento and storefront
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws \Magento\DataExporter\Exception\UnableRetrieveData
     * @throws \Zend_Db_Statement_Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityType = $this->getEntityType($input);
        // TODO: MC-30961 clean product ids from storefront.catalog.category.update topic

        // @todo eliminate dependency on indexer
        if (!$entityType || $entityType === self::ENTITY_TYPE_CATEGORY) {
            $this->categoryFeedIndexer->executeFull();
        }
        if (!$entityType || $entityType === self::ENTITY_TYPE_PRODUCT) {
            $this->productFeedIndexer->executeFull();
        }

        foreach ($this->storeManager->getStores() as $store) {
            if (!$entityType || $entityType === self::ENTITY_TYPE_PRODUCT) {
                $this->syncProducts($output, $store);
            }
            if (!$entityType || $entityType === self::ENTITY_TYPE_CATEGORY) {
                $this->syncCategories($output, $store);
            }
        }
    }

    /**
     * Sync products
     *
     * @param OutputInterface $output
     * @param StoreInterface $store
     */
    protected function syncProducts(OutputInterface $output, StoreInterface $store): void
    {
        $output->writeln("<info>Sync products for store {$store->getCode()}</info>");
        $this->measure(
            function () use ($output, $store) {
                $productsFeed = $this->feedPool->getFeed('products');
                $processedN = 0;
                foreach ($this->catalogEntityIdsProvider->getProductIds((int)$store->getId()) as $productIds) {
                    $deleted = [];
                    foreach ($productsFeed->getDeletedByIds($productIds, [$store->getCode()]) as $product) {
                        $deleted[] = ['entity_id' => (int)$product['productId']];
                        unset($productIds[$product['productId']]);
                    }

                    if (!empty($deleted)) {
                        $message = $this->messageBuilder->build(
                            ProductsConsumer::PRODUCTS_DELETED_EVENT_TYPE,
                            $deleted,
                            $store->getCode()
                        );
                        $this->productsConsumer->processMessage($message);
                    }

                    $message = $this->messageBuilder->build(
                        ProductsConsumer::PRODUCTS_UPDATED_EVENT_TYPE,
                        $this->buildMessageEntitiesArray($productIds),
                        $store->getCode()
                    );
                    $this->productsConsumer->processMessage($message);

                    $output->write('.');
                    $processedN += count($productIds);
                }
                return $processedN;
            },
            $output
        );
    }

    /**
     * Sync categories
     *
     * @param OutputInterface $output
     * @param StoreInterface $store
     */
    protected function syncCategories(OutputInterface $output, StoreInterface $store): void
    {
        $output->writeln("<info>Sync categories for store {$store->getCode()}</info>");
        $this->measure(
            function () use ($output, $store) {
                $categoriesFeed = $this->feedPool->getFeed('categories');

                $processedN = 0;
                foreach ($this->catalogEntityIdsProvider->getCategoryIds((int)$store->getId()) as $categoryIds) {
                    $deleted = [];
                    foreach ($categoriesFeed->getDeletedByIds($categoryIds, [$store->getCode()]) as $category) {
                        $deleted[] = ['entity_id' => $category['categoryId']];
                        unset($categoryIds[$category['categoryId']]);
                    }

                    if (!empty($deleted)) {
                        $message = $this->messageBuilder->build(
                            CategoriesConsumer::CATEGORIES_DELETED_EVENT_TYPE,
                            $deleted,
                            $store->getCode()
                        );
                        $this->categoriesConsumer->processMessage($message);
                    }

                    $message = $this->messageBuilder->build(
                        CategoriesConsumer::CATEGORIES_UPDATED_EVENT_TYPE,
                        $this->buildMessageEntitiesArray($categoryIds),
                        $store->getCode()
                    );
                    $this->categoriesConsumer->processMessage($message);

                    $output->write('.');
                    $processedN += count($categoryIds);
                }
                return $processedN;
            },
            $output
        );
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
     * Measure sync time
     *
     * @param callable $func
     * @param OutputInterface $output
     * @return void
     */
    private function measure(callable $func, OutputInterface $output): void
    {
        $start = \time();
        $processedN = $func();
        $output->writeln(
            \sprintf('Complete "%s" entities in "%s"', $processedN, Helper::formatTime(\time() - $start))
        );
    }

    /**
     * Get processed entity type
     *
     * @param InputInterface $input
     * @return string|null
     */
    public function getEntityType(InputInterface $input): ?string
    {
        return $input->getOption(self::INPUT_ENTITY_TYPE) ?: null;
    }
}
