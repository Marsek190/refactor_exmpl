<?php

namespace Dyson\Services\Product\Bundles\Pipes;

use Dyson\Services\Product\Bundles\HasRemainsBundleChecker;
use Dyson\Services\Product\Bundles\Model\Bundle;
use Dyson\Services\Product\Bundles\Model\BundlePart;
use Dyson\Services\Product\Storage\DisabledProductsStorage;

class VisibilityBundlePipe implements BundlePipe
{
    private $remainsBundleChecker;

    /**
     * @param HasRemainsBundleChecker $remainsBundleChecker
     */
    public function __construct(HasRemainsBundleChecker $remainsBundleChecker)
    {
        $this->remainsBundleChecker = $remainsBundleChecker;
    }

    /** @inheritDoc */
    public function pipe(Bundle $bundle, DisabledProductsStorage $storage)
    {
        if (!$bundle->isHairDryer()) {
            return;
        }

        if (!$this->remainsBundleChecker->check($bundle)) {
            $storage->disableVisibility($bundle->id());
            return;
        }

        $parts = $bundle->parts();
        $products = array_filter($parts, function (BundlePart $part) { return !$part->isAccessory(); });
        $productIds = array_map(function (BundlePart $part) { return $part->id(); }, $products);
        foreach ($productIds as $productId) {
            $storage->disableVisibility($productId);
        }
    }
}
