<?php

namespace Dyson\Services\Product\Picture;

class ProductPictureFetcherFactory
{
    /**
     * @param int $productId
     * @param string $categoryPath
     * @return ProductPictureFetcher
     */
    public function create($productId, $categoryPath)
    {
        return new CommonProductPictureFetcher($productId, $categoryPath);
    }
}
