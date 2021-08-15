<?php

namespace Dyson\Services\Product\Bundles;

use Dyson\Services\Product\Bundles\Model\BundlePart;
use Dyson\Services\Product\Bundles\Collection\BundlePartsRemains;

class StocksCounter
{
    /** @var BundlePartsRemains */
    private $bashRemains;

    /** @var BundlePartsRemains */
    private $tpRemains;

    public function __construct(BundlePart ...$parts)
    {
        $this->bashRemains = new BundlePartsRemains();
        $this->tpRemains = new BundlePartsRemains();

        foreach ($parts as $part) {
            $this->tpRemains->append($part->tpRemains());
            $this->bashRemains->append($part->bashRemains());
        }
    }

    /** @return bool */
    public function canBuy()
    {
        return $this->tpRemains->hasRemains() || $this->bashRemains->hasRemains();
    }
}
