<?php

namespace Dyson\Services\Product\Logo;

abstract class AbstractProductLogoFetcher implements ProductLogoFetcher
{
    /** @return string|null */
    public function fetch()
    {
        if (!is_file($this->getServerFilePath())) {
            return null;
        }

        return $this->getCdnFilePath();
    }

    /** @return string */
    protected abstract function getServerFilePath();

    /** @return string */
    protected abstract function getCdnFilePath();

    /** @return string */
    protected function getRootPath()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }
}
