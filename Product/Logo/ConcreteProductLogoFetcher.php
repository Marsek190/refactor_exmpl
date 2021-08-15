<?php

namespace Dyson\Services\Product\Logo;

class ConcreteProductLogoFetcher extends AbstractProductLogoFetcher
{
    private $productId;
    private $categoryPath;

    /**
     * @param int $productId
     * @param string $categoryPath
     */
    public function __construct($productId, $categoryPath)
    {
        $this->productId = $productId;
        $this->categoryPath = $categoryPath;
    }

    /** @inheritDoc */
    protected function getServerFilePath()
    {
        return sprintf(
            '%s/data/images/products/%s/%s/family.png',
            $this->getRootPath(),
            $this->categoryPath,
            $this->productId
        );
    }

    /** @inheritDoc */
    protected function getCdnFilePath()
    {
        return sprintf(
            '%s/data/images/products/%s/%s/family.png',
            DYSON_CDN,
            $this->categoryPath,
            $this->productId
        );
    }
}
