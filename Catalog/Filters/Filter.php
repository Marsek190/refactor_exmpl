<?php

namespace Dyson\Services\Catalog\Filters;

interface Filter
{
    /**
     * @param array $product
     * @return bool
     */
    public function isSatisfiedBy(array $product);

    /** @return array */
    public function getAvailableFilters();

    /** @return array */
    public function getAllFilters();

    /** @return array */
    public function getFilterQueries();
}
