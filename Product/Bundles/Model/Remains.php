<?php

namespace Dyson\Services\Product\Bundles\Model;

class Remains
{
    private $quantity;
    private $limit;

    /**
     * @param int $quantity
     * @param int $limit
     */
    public function __construct($quantity, $limit)
    {
        $this->quantity = $quantity;
        $this->limit = $limit;
    }

    /** @return bool */
    public function inStock()
    {
        return $this->quantity > 0 && $this->quantity >= $this->limit;
    }
}
