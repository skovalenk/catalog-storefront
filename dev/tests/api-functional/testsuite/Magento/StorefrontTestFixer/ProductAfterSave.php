<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\StorefrontTestFixer;

use Magento\Catalog\Model\ResourceModel\Product;
use Magento\CatalogStorefrontConnector\Plugin\CollectProductsDataOnSave;
use Magento\Framework\Model\AbstractModel;
use Magento\TestFramework\Helper\Bootstrap;

/**
 * Plugin for collect products data product save. Handle case when indexer mode is set to "runtime"
 */
class ProductAfterSave extends CollectProductsDataOnSave
{
    /**
     * @inheritDoc
     *
     * Ad-hoc solution. Force run consumers after product save inside test-case
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterSave(
        Product $subject,
        Product $result,
        AbstractModel $product
    ): Product {
        $result = parent::afterSave($subject, $result, $product);

        $objectManager = Bootstrap::getObjectManager();
        /** @var ConsumerInvoker $consumerInvoker */
        $consumerInvoker = $objectManager->get(ConsumerInvoker::class);
        $consumerInvoker->invoke(true);

        return $result;
    }
}