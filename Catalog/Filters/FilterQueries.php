<?php

namespace Dyson\Services\Catalog\Filters;

use ArrayIterator;
use IteratorIterator;

class FilterQueries extends IteratorIterator
{
    /**
     * @param array $filterQueries
     */
    public function __construct(array $filterQueries)
    {
        parent::__construct(new ArrayIterator($filterQueries));
    }

    /** @return string */
    public function key()
    {
        return mb_strtoupper(parent::key());
    }

    /** @return array */
    public function toArray()
    {
        return iterator_to_array($this);
    }
}
