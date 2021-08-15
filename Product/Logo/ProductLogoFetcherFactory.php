<?php

namespace Dyson\Services\Product\Logo;

class ProductLogoFetcherFactory
{
    /**
     * @param int $productId
     * @param string $categoryPath
     * @return ProductLogoFetcher
     */
    public function create($productId, $categoryPath)
    {
        $fetchers = [
            new ConcreteProductLogoFetcher($productId, $categoryPath),
            new CommonSectionProductLogoFetcher($categoryPath),
        ];

        return new ChainProductLogoFetcher(...$fetchers);
    }
}
