<?php

namespace Dyson\Services\Product\Bundles;

use Dyson\Services\Product\Bundles\Model\Bundle;
use Dyson\Services\Product\Bundles\Model\BundlePart;

class HasRemainsBundleChecker
{
    /**
     * @param Bundle $bundle
     * @return bool
     */
    public function check(Bundle $bundle)
    {
        if (!$bundle->isActive()) {
            return false;
        }

        $parts = $bundle->parts();
        $disabledProducts = array_filter($parts, function (BundlePart $part) { return !$part->isActive(); });

        if (count($disabledProducts) !== 0) {
            return false;
        }

        $stocks = new StocksCounter(...$bundle->parts());

        return $stocks->canBuy();
    }
}
