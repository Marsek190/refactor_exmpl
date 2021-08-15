<?php

namespace Dyson\Services\Product\Picture;

class CommonProductPictureFetcher implements ProductPictureFetcher
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
    public function fetch()
    {
        return sprintf(
            '%s/data/images/products/%s/%s/273_303_%s.jpg',
            DYSON_CDN,
            $this->categoryPath,
            $this->productId,
            $this->productId
        );
    }
}
