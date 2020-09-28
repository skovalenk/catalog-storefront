<?php
# Generated by the Magento PHP proto generator.  DO NOT EDIT!

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\CatalogStorefrontApi\Api\Data;

use Magento\Framework\ObjectManagerInterface;

/**
 * Autogenerated description for Product class
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
final class ProductMapper
{
    /**
     * @var string
     */
    private static $dtoClassName = ProductInterface::class;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
    * Set the data to populate the DTO
    *
    * @param mixed $data
    * @return $this
    */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
    * Build new DTO populated with the data
    *
    * @return Product
    */
    public function build()
    {
        $dto = $this->objectManager->create(self::$dtoClassName);
        foreach ($this->data as $key => $valueData) {
            if ($valueData === null) {
                continue;
            }
            $this->setByKey($dto, $key, $valueData);
        }
        return $dto;
    }

    /**
    * Set the value of the key using setters.
    *
    * In case if the field is object, the corresponding Mapper would be create and DTO representing the field data
    * would be built
    *
    * @param Product $dto
    * @param string $key
    * @param mixed $value
    */
    private function setByKey(Product $dto, string $key, $value): void
    {
        switch ($key) {
            case "id":
                $dto->setId((string) $value);
                break;
            case "attribute_set_id":
                $dto->setAttributeSetId((string) $value);
                break;
            case "has_options":
                $dto->setHasOptions((bool) $value);
                break;
            case "created_at":
                $dto->setCreatedAt((string) $value);
                break;
            case "updated_at":
                $dto->setUpdatedAt((string) $value);
                break;
            case "sku":
                $dto->setSku((string) $value);
                break;
            case "type_id":
                $dto->setTypeId((string) $value);
                break;
            case "status":
                $dto->setStatus((string) $value);
                break;
            case "stock_status":
                $dto->setStockStatus((string) $value);
                break;
            case "name":
                $dto->setName((string) $value);
                break;
            case "description":
                $dto->setDescription((string) $value);
                break;
            case "short_description":
                $dto->setShortDescription((string) $value);
                break;
            case "url_key":
                $dto->setUrlKey((string) $value);
                break;
            case "qty":
                $dto->setQty((float) $value);
                break;
            case "tax_class_id":
                $dto->setTaxClassId((string) $value);
                break;
            case "weight":
                $dto->setWeight((float) $value);
                break;
            case "images":
                $convertedArray = [];
                foreach ($value as $element) {
                    $convertedArray[] = $this->objectManager
                        ->create(\Magento\CatalogStorefrontApi\Api\Data\ImageMapper::class)
                        ->setData($element)
                        ->build();
                }
                $dto->setImages($convertedArray);
                break;
            case "videos":
                $convertedArray = [];
                foreach ($value as $element) {
                    $convertedArray[] = $this->objectManager
                        ->create(\Magento\CatalogStorefrontApi\Api\Data\VideoMapper::class)
                        ->setData($element)
                        ->build();
                }
                $dto->setVideos($convertedArray);
                break;
            case "samples":
                $convertedArray = [];
                foreach ($value as $element) {
                    $convertedArray[] = $this->objectManager
                        ->create(\Magento\CatalogStorefrontApi\Api\Data\SampleMapper::class)
                        ->setData($element)
                        ->build();
                }
                $dto->setSamples($convertedArray);
                break;
            case "visibility":
                $dto->setVisibility((string) $value);
                break;
            case "dynamic_attributes":
                $convertedArray = [];
                foreach ($value as $element) {
                    $convertedArray[] = $this->objectManager
                        ->create(\Magento\CatalogStorefrontApi\Api\Data\DynamicAttributeValueMapper::class)
                        ->setData($element)
                        ->build();
                }
                $dto->setDynamicAttributes($convertedArray);
                break;
            case "meta_description":
                $dto->setMetaDescription((string) $value);
                break;
            case "meta_keyword":
                $dto->setMetaKeyword((string) $value);
                break;
            case "meta_title":
                $dto->setMetaTitle((string) $value);
                break;
            case "categories":
                $dto->setCategories((array) $value);
                break;
            case "required_options":
                $dto->setRequiredOptions((string) $value);
                break;
            case "created_in":
                $dto->setCreatedIn((string) $value);
                break;
            case "updated_in":
                $dto->setUpdatedIn((string) $value);
                break;
            case "quantity_and_stock_status":
                $dto->setQuantityAndStockStatus((string) $value);
                break;
            case "options_container":
                $dto->setOptionsContainer((string) $value);
                break;
            case "msrp_display_actual_price_type":
                $dto->setMsrpDisplayActualPriceType((string) $value);
                break;
            case "is_returnable":
                $dto->setIsReturnable((string) $value);
                break;
            case "url_suffix":
                $dto->setUrlSuffix((string) $value);
                break;
            case "options":
                $convertedArray = [];
                foreach ($value as $element) {
                    $convertedArray[] = $this->objectManager
                        ->create(\Magento\CatalogStorefrontApi\Api\Data\OptionMapper::class)
                        ->setData($element)
                        ->build();
                }
                $dto->setOptions($convertedArray);
                break;
            case "url_rewrites":
                $convertedArray = [];
                foreach ($value as $element) {
                    $convertedArray[] = $this->objectManager
                        ->create(\Magento\CatalogStorefrontApi\Api\Data\UrlRewriteMapper::class)
                        ->setData($element)
                        ->build();
                }
                $dto->setUrlRewrites($convertedArray);
                break;
            case "country_of_manufacture":
                $dto->setCountryOfManufacture((string) $value);
                break;
            case "gift_message_available":
                $dto->setGiftMessageAvailable((bool) $value);
                break;
            case "special_price":
                $dto->setSpecialPrice((float) $value);
                break;
            case "special_from_date":
                $dto->setSpecialFromDate((string) $value);
                break;
            case "special_to_date":
                $dto->setSpecialToDate((string) $value);
                break;
            case "product_links":
                $convertedArray = [];
                foreach ($value as $element) {
                    $convertedArray[] = $this->objectManager
                        ->create(\Magento\CatalogStorefrontApi\Api\Data\ProductLinkMapper::class)
                        ->setData($element)
                        ->build();
                }
                $dto->setProductLinks($convertedArray);
                break;
            case "canonical_url":
                $dto->setCanonicalUrl((string) $value);
                break;
            case "price_view":
                $dto->setPriceView((string) $value);
                break;
            case "links_purchased_separately":
                $dto->setLinksPurchasedSeparately((bool) $value);
                break;
            case "only_x_left_in_stock":
                $dto->setOnlyXLeftInStock((float) $value);
                break;
            case "grouped_items":
                $convertedArray = [];
                foreach ($value as $element) {
                    $convertedArray[] = $this->objectManager
                        ->create(\Magento\CatalogStorefrontApi\Api\Data\GroupedItemMapper::class)
                        ->setData($element)
                        ->build();
                }
                $dto->setGroupedItems($convertedArray);
                break;
            case "product_options":
                $convertedArray = [];
                foreach ($value as $element) {
                    $convertedArray[] = $this->objectManager
                        ->create(\Magento\CatalogStorefrontApi\Api\Data\ProductOptionMapper::class)
                        ->setData($element)
                        ->build();
                }
                $dto->setProductOptions($convertedArray);
                break;
            case "shopper_input_options":
                $convertedArray = [];
                foreach ($value as $element) {
                    $convertedArray[] = $this->objectManager
                        ->create(\Magento\CatalogStorefrontApi\Api\Data\ProductShopperInputOptionMapper::class)
                        ->setData($element)
                        ->build();
                }
                $dto->setShopperInputOptions($convertedArray);
                break;
        }
    }
}
