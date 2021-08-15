<?php

namespace Dyson\Services\Catalog\Filters;

class DefaultFilter implements Filter
{
    /** @inheritDoc */
    public function isSatisfiedBy(array $product)
    {
        return true;
    }

    /** @inheritDoc */
    public function getAvailableFilters()
    {
        return [];
    }

    /** @inheritDoc */
    public function getAllFilters()
    {
        return [];
    }

    /** @inheritDoc */
    public function getFilterQueries()
    {
        return [];
    }
}
