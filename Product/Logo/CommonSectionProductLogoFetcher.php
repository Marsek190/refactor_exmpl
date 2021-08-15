<?php

namespace Dyson\Services\Product\Logo;

class CommonSectionProductLogoFetcher extends AbstractProductLogoFetcher
{
    private $categoryPath;

    /**
     * @param string $categoryPath
     */
    public function __construct($categoryPath)
    {
        $this->categoryPath = $categoryPath;
    }

    /** @inheritDoc */
    protected function getServerFilePath()
    {
        return sprintf(
            '%s/data/images/products/%s/family.png',
            $this->getRootPath(),
            $this->categoryPath
        );
    }

    /** @inheritDoc */
    protected function getCdnFilePath()
    {
        return sprintf(
            '%s/data/images/products/%s/family.png',
            DYSON_CDN,
            $this->categoryPath
        );
    }
}
