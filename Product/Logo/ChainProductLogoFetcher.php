<?php

namespace Dyson\Services\Product\Logo;

class ChainProductLogoFetcher implements ProductLogoFetcher
{
    private $fetchers;

    /**
     * @param ProductLogoFetcher[] $fetchers
     */
    public function __construct(ProductLogoFetcher ...$fetchers)
    {
        $this->fetchers = $fetchers;
    }

    /** @inheritDoc */
    public function fetch()
    {
        foreach ($this->fetchers as $fetcher) {
            $filePath = $fetcher->fetch();
            if ($filePath !== null) {
                return $filePath;
            }
        }

        return null;
    }
}
