<?php

namespace Dyson\Services\Product\Bundles\Pipes;

use Dyson\Services\Product\Bundles\Model\Bundle;
use Dyson\Services\Product\Storage\DisabledProductsStorage;

interface BundlePipe
{
    /**
     * @param Bundle $bundle
     * @param DisabledProductsStorage $storage
     * @return void
     */
    public function pipe(Bundle $bundle, DisabledProductsStorage $storage);
}
