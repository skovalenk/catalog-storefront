<?php
# Generated by the Magento PHP proto generator.  DO NOT EDIT!

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\CatalogStorefrontApi\Api\Data;

/**
 * Autogenerated description for Category class
 *
 * phpcs:disable Magento2.PHP.FinalImplementation
 * @SuppressWarnings(PHPMD)
 * @SuppressWarnings(PHPCPD)
 */
final class Category implements CategoryInterface
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $position;

    /**
     * @var int
     */
    private $level;

    /**
     * @var int
     */
    private $childrenCount;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $displayMode;

    /**
     * @var string
     */
    private $defaultSortBy;

    /**
     * @var string
     */
    private $urlKey;

    /**
     * @var string
     */
    private $urlPath;

    /**
     * @var bool
     */
    private $isActive;

    /**
     * @var bool
     */
    private $isAnchor;

    /**
     * @var bool
     */
    private $includeInMenu;

    /**
     * @var array
     */
    private $availableSortBy;

    /**
     * @var array
     */
    private $breadcrumbs;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $canonicalUrl;

    /**
     * @var int
     */
    private $productCount;

    /**
     * @var array
     */
    private $children;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $parentId;

    /**
     * @var string
     */
    private $metaTitle;

    /**
     * @var string
     */
    private $metaDescription;

    /**
     * @var string
     */
    private $metaKeywords;

    /**
     * @var array
     */
    private $attributes;
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->id;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setId(string $value): void
    {
        $this->id = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getPath(): string
    {
        return (string) $this->path;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setPath(string $value): void
    {
        $this->path = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getPosition(): int
    {
        return (int) $this->position;
    }
    
    /**
     * @inheritdoc
     *
     * @param int $value
     * @return void
     */
    public function setPosition(int $value): void
    {
        $this->position = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getLevel(): int
    {
        return (int) $this->level;
    }
    
    /**
     * @inheritdoc
     *
     * @param int $value
     * @return void
     */
    public function setLevel(int $value): void
    {
        $this->level = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getChildrenCount(): int
    {
        return (int) $this->childrenCount;
    }
    
    /**
     * @inheritdoc
     *
     * @param int $value
     * @return void
     */
    public function setChildrenCount(int $value): void
    {
        $this->childrenCount = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getName(): string
    {
        return (string) $this->name;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setName(string $value): void
    {
        $this->name = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getDisplayMode(): string
    {
        return (string) $this->displayMode;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setDisplayMode(string $value): void
    {
        $this->displayMode = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getDefaultSortBy(): string
    {
        return (string) $this->defaultSortBy;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setDefaultSortBy(string $value): void
    {
        $this->defaultSortBy = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getUrlKey(): string
    {
        return (string) $this->urlKey;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setUrlKey(string $value): void
    {
        $this->urlKey = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getUrlPath(): string
    {
        return (string) $this->urlPath;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setUrlPath(string $value): void
    {
        $this->urlPath = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return bool
     */
    public function getIsActive(): bool
    {
        return (bool) $this->isActive;
    }
    
    /**
     * @inheritdoc
     *
     * @param bool $value
     * @return void
     */
    public function setIsActive(bool $value): void
    {
        $this->isActive = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return bool
     */
    public function getIsAnchor(): bool
    {
        return (bool) $this->isAnchor;
    }
    
    /**
     * @inheritdoc
     *
     * @param bool $value
     * @return void
     */
    public function setIsAnchor(bool $value): void
    {
        $this->isAnchor = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return bool
     */
    public function getIncludeInMenu(): bool
    {
        return (bool) $this->includeInMenu;
    }
    
    /**
     * @inheritdoc
     *
     * @param bool $value
     * @return void
     */
    public function setIncludeInMenu(bool $value): void
    {
        $this->includeInMenu = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string[]
     */
    public function getAvailableSortBy(): array
    {
        return (array) $this->availableSortBy;
    }
    
    /**
     * @inheritdoc
     *
     * @param string[] $value
     * @return void
     */
    public function setAvailableSortBy(array $value): void
    {
        $this->availableSortBy = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return \Magento\CatalogStorefrontApi\Api\Data\BreadcrumbInterface[]
     */
    public function getBreadcrumbs(): array
    {
        return (array) $this->breadcrumbs;
    }
    
    /**
     * @inheritdoc
     *
     * @param \Magento\CatalogStorefrontApi\Api\Data\BreadcrumbInterface[] $value
     * @return void
     */
    public function setBreadcrumbs(array $value): void
    {
        $this->breadcrumbs = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getDescription(): string
    {
        return (string) $this->description;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setDescription(string $value): void
    {
        $this->description = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getCanonicalUrl(): string
    {
        return (string) $this->canonicalUrl;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setCanonicalUrl(string $value): void
    {
        $this->canonicalUrl = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getProductCount(): int
    {
        return (int) $this->productCount;
    }
    
    /**
     * @inheritdoc
     *
     * @param int $value
     * @return void
     */
    public function setProductCount(int $value): void
    {
        $this->productCount = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string[]
     */
    public function getChildren(): array
    {
        return (array) $this->children;
    }
    
    /**
     * @inheritdoc
     *
     * @param string[] $value
     * @return void
     */
    public function setChildren(array $value): void
    {
        $this->children = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getImage(): string
    {
        return (string) $this->image;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setImage(string $value): void
    {
        $this->image = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getParentId(): string
    {
        return (string) $this->parentId;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setParentId(string $value): void
    {
        $this->parentId = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getMetaTitle(): string
    {
        return (string) $this->metaTitle;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setMetaTitle(string $value): void
    {
        $this->metaTitle = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getMetaDescription(): string
    {
        return (string) $this->metaDescription;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setMetaDescription(string $value): void
    {
        $this->metaDescription = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getMetaKeywords(): string
    {
        return (string) $this->metaKeywords;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setMetaKeywords(string $value): void
    {
        $this->metaKeywords = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return \Magento\CatalogStorefrontApi\Api\Data\AttributeInterface[]
     */
    public function getAttributes(): array
    {
        return (array) $this->attributes;
    }
    
    /**
     * @inheritdoc
     *
     * @param \Magento\CatalogStorefrontApi\Api\Data\AttributeInterface[] $value
     * @return void
     */
    public function setAttributes(array $value): void
    {
        $this->attributes = $value;
    }
}
