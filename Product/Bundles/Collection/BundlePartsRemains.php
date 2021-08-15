<?php

namespace Dyson\Services\Product\Bundles\Collection;

use ArrayIterator;
use IteratorIterator;
use Dyson\Services\Product\Bundles\Model\Remains;

class BundlePartsRemains extends IteratorIterator
{
    /** @var Remain[] */
    private $remains = [];

    public function __construct()
    {
        parent::__construct(new ArrayIterator());
    }

    /** @inheritDoc */
    public function getInnerIterator()
    {
        return $this->remains;
    }

    /**
     * @param Remains $remains
     * @return void
     */
    public function append(Remains $remains)
    {
        $this->remains[] = $remains;
    }

    /** @return bool */
    public function hasRemains()
    {
        /** @var Remains $remains */
        foreach ($this as $remains) {
            if (!$remains->inStock()) {
                return false;
            }
        }

        return true;
    }
}
