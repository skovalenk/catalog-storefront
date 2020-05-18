<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\CatalogStorefrontGraphQl\Resolver\Product;

use Magento\Catalog\Model\Layer\Resolver;
use Magento\CatalogStorefrontApi\Api\Data\OptionInterface;
use Magento\CatalogStorefrontApi\Api\Data\OptionValueInterface;
use Magento\CatalogStorefrontApi\Api\Data\ProductLinkInterface;
use Magento\CatalogStorefrontApi\Api\Data\ProductResultContainerInterface;
use Magento\CatalogStorefrontApi\Api\Data\ProductsGetResultInterface;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\BatchRequestItemInterface;

/**
 * Format response from Storefront service
 */
class OutputFormatter
{
    /**
     * Format Storefront output for GraphQL response
     *
     * @param ProductResultContainerInterface $result
     * @param GraphQlInputException $e
     * @param BatchRequestItemInterface $request
     * @param array $additionalInfo
     * @return array
     * @throws GraphQlInputException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(
        ProductsGetResultInterface $result,
        GraphQlInputException $e,
        BatchRequestItemInterface $request,
        array $additionalInfo = []
    ) {
//        $errors = $result->getErrors() ?: $additionalInfo['errors'] ?: [];
//        if (!empty($errors)) {
//            //ad-hoc solution with __() as GraphQlInputException accepts Phrase in construct
//            //TODO: change with error holder
//            throw new GraphQlInputException(__(\implode('; ', \array_map('\strval', $errors))));
//        }

        $items = array_map(function (\Magento\CatalogStorefrontApi\Api\Data\ProductInterface $item) {
            $result = [
                'attribute_set_id' => $item->getAttributeSetId(),
                'categories' => $item->getCategories(),
                'created_at' => $item->getCreatedAt(),
                'updated_at' => $item->getUpdatedAt(),
                'sku' => $item->getSku(),
                'id' => $item->getId(),
                'entity_id' => $item->getId(),
                'type_id' => $item->getTypeId(),
                'description' => ['html' => $item->getDescription() ?? null],
                'name' => $item->getName(),
                'stock_status' => $item->getStockStatus(),
                'url_key' => $item->getUrlKey(),
                'url_suffix' => $item->getUrlSuffix(),
                'swatch_image' => $item->getSwatchImage(),
                'weight' => $item->getWeight(),
                'meta_description' => $item->getMetaDescription(),
                'meta_keyword' => $item->getMetaKeyword(),
                'meta_title' => $item->getMetaTitle(),
                'country_of_manufacture' => $item->getCountryOfManufacture(),
                'gift_message_available' => (int)$item->getGiftMessageAvailable(),
                'options_container' => $item->getOptionsContainer(),
                'special_price' => $item->getSpecialPrice(),
                'special_from_date' => $item->getSpecialFromDate(),
                'special_to_date' => $item->getSpecialToDate(),
            ];

            if ($item->getImage()) {
                $result['image']['url'] = $item->getImage()->getUrl() ?? "";
                $result['image']['label'] = $item->getImage()->getLabel() ?? "";
            }


            if ($item->getSmallImage()) {
                $result['small_image']['url'] = $item->getSmallImage()->getUrl() ?? "";
                $result['small_image']['label'] = $item->getSmallImage()->getLabel() ?? "";
            }

            if ($item->getThumbnail()) {
                $result['thumbnail']['url'] = $item->getThumbnail()->getUrl() ?? "";
                $result['thumbnail']['label'] = $item->getThumbnail()->getLabel() ?? "";
            }

            //TODO: Revise options structure and remove free form structure from index/api
            if ($item->getOptions()) {
                $result['options'] = array_map(function (OptionInterface $option) {
                    $output = [
                        'option_id' => $option->getOptionId(),
                        'product_id' => $option->getProductId(),
                        'type' => $option->getType(),
                        'is_require' => $option->getIsRequire(),
                        'sku' => $option->getSku(),
                        'max_characters' => $option->getMaxCharacters(),
                        'file_extension' => $option->getFileExtension(),
                        'image_size_x' => $option->getImageSizeX(),
                        'image_size_y' => $option->getImageSizeY(),
                        'sort_order' => $option->getSortOrder(),
                        'default_title' => $option->getDefaultTitle(),
                        'store_title' => $option->getStoreTitle(),
                        'title' => $option->getTitle(),
                        'default_price' => $option->getDefaultPrice(),
                        'default_price_type' => $option->getDefaultPriceType(),
                        'store_price' => $option->getStorePrice(),
                        'store_price_type' => $option->getStorePriceType(),
                        'price' => $option->getPrice(),
                        'price_type' => $option->getPriceType(),
                        'required' => $option->getRequired(),
                        'product_sku' => $option->getProductSku(),

                    ];
                    $output['value'] = array_map(function (OptionValueInterface $value) {
                        return [
                            'option_id' => $value->getOptionId(),
                            'option_type_id' => $value->getOptionTypeId(),
                            'product_id' => $value->getProductId(),
                            'type' => $value->getType(),
                            'is_require' => $value->getIsRequire(),
                            'sku' => $value->getSku(),
                            'max_characters' => $value->getMaxCharacters(),
                            'file_extension' => $value->getFileExtension(),
                            'image_size_x' => $value->getImageSizeX(),
                            'image_size_y' => $value->getImageSizeY(),
                            'sort_order' => $value->getSortOrder(),
                            'default_title' => $value->getDefaultTitle(),
                            'store_title' => $value->getStoreTitle(),
                            'title' => $value->getTitle(),
                            'default_price' => $value->getDefaultPrice(),
                            'default_price_type' => $value->getDefaultPriceType(),
                            'store_price' => $value->getStorePrice(),
                            'store_price_type' => $value->getStorePriceType(),
                            'price' => $value->getPrice(),
                            'price_type' => $value->getPriceType(),

                        ];
                    }, $option->getValue());

                    //Convert simple option types from arrays
                    $simpleOptionTypes = ['date_time', 'field', 'area', 'file'];
                    if (isset($output['type']) && in_array($output['type'], $simpleOptionTypes)) {
                        $output['value'] = reset($output['value']);
                    }

                    return $output;
                }, $item->getOptions());
            }

            $result['product_links'] = array_map(function (ProductLinkInterface $item) {
                return [
                    "linked_product_sku" => $item->getLinkedProductSku(),
                    "linked_product_type" => $item->getLinkedProductType(),
                    "link_type_id" => $item->getLinkTypeId(),
                    "position" => $item->getPosition(),
                    "sku" => $item->getSku(),
                    "link_type" => $item->getLinkType(),
                ];
            }, $item->getProductLinks());

            return $result;
        }, $result->getItems());


        $metaInfo = $additionalInfo['meta_info'] ?? [];
        $aggregations = $additionalInfo['aggregations'] ?? [];
        return [
            'items' => $items,
            'aggregations' => $aggregations,
            'total_count' => $metaInfo['total_count'] ?? null,
            'page_info' => [
                'page_size' => $metaInfo['page_size'] ?? null,
                'current_page' => $metaInfo['current_page'] ?? null,
                'total_pages' => $metaInfo['total_pages'] ?? null,
            ],
            // for backward compatibility: support "filters" field
            'layer_type' => isset($request->getArgs()['search'])
                ? Resolver::CATALOG_LAYER_SEARCH
                : Resolver::CATALOG_LAYER_CATEGORY,
        ];
    }
}
