<?php

namespace Dyson\Services\Product\Bundles\Pipes;

use Dyson\Services\Product\Bundles\HasRemainsBundleChecker;
use Dyson\Services\Product\Bundles\Model\Bundle;
use Dyson\Services\Product\Storage\DisabledProductsStorage;

class AvailabilityBundlePipe implements BundlePipe
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
        if ($bundle->isHairDryer()) {
            return;
        }

        if (!$this->remainsBundleChecker->check($bundle)) {
            $storage->disableAvailability($bundle->id());
        }
    }
}
