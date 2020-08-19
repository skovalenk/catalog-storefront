<?php
# Generated by the Magento PHP proto generator.  DO NOT EDIT!

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\CatalogStorefrontApi\Api\Data;

use Magento\Framework\ObjectManagerInterface;

final class ProductShopperInputOptionArrayMapper
{
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
    * Convert the DTO to the array with the data
    *
    * @param ProductShopperInputOption $dto
    * @return array
    */
    public function convertToArray(ProductShopperInputOption $dto)
    {
        $result = [];
        $result["id"] = $dto->getId();
        $result["label"] = $dto->getLabel();
        $result["sort_order"] = $dto->getSortOrder();
        $result["required"] = $dto->getRequired();
        $result["render_type"] = $dto->getRenderType();
        /** Convert complex Array field **/
        $fieldArray = [];
        foreach ($dto->getPrice() as $fieldArrayDto) {
            $fieldArray[] = $this->objectManager->get(\Magento\CatalogStorefrontApi\Api\Data\PriceArrayMapper::class)
                ->convertToArray($fieldArrayDto);
        }
        $result["price"] = $fieldArray;
        $result["value"] = $dto->getValue();
        $result["max_characters"] = $dto->getMaxCharacters();
        $result["file_extension"] = $dto->getFileExtension();
        $result["image_size_x"] = $dto->getImageSizeX();
        $result["image_size_y"] = $dto->getImageSizeY();
        return $result;
    }
}