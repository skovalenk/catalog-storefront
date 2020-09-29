<?php
# Generated by the Magento PHP proto generator.  DO NOT EDIT!

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\CatalogStorefrontApi\Api\Data;

/**
 * Autogenerated description for ImportCategoriesRequest interface
 * TODO should be regenerated https://github.com/magento/catalog-storefront/issues/41
 *
 * @SuppressWarnings(PHPMD.BooleanGetMethodName)
 */
interface ImportCategoryDataRequestInterface
{
    /**
     * Autogenerated description for getCategories() interface method
     *
     * @return \Magento\CatalogStorefrontApi\Api\Data\CategoryInterface
     */
    public function getCategory(): \Magento\CatalogStorefrontApi\Api\Data\CategoryInterface;

    /**
     * Autogenerated description for setCategories() interface method
     *
     * @param \Magento\CatalogStorefrontApi\Api\Data\CategoryInterface $category
     * @return void
     */
    public function setCategory(\Magento\CatalogStorefrontApi\Api\Data\CategoryInterface $category): void;

    /**
     * Autogenerated description for getAttributes() interface method
     *
     * @return string[]
     */
    public function getAttributes(): array;

    /**
     * Autogenerated description for setAttributes() interface method
     *
     * @param string[]
     * @return void
     */
    public function setAttributes(array $attributes): void;
}