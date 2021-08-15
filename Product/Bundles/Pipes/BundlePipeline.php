<?php

namespace Dyson\Services\Product\Bundles\Pipes;

use Dyson\Services\Product\Bundles\Model\Bundle;
use Dyson\Services\Product\Storage\DisabledProductsStorage;

class BundlePipeline implements BundlePipe
{
    private $pipes;

    /**
     * @param BundlePipe[] $pipes
     */
    public function __construct(BundlePipe ...$pipes)
    {
        $this->pipes = $pipes;
    }

    /** @inheritDoc */
    public function pipe(Bundle $bundle, DisabledProductsStorage $storage)
    {
        foreach ($this->pipes as $pipe) {
            $pipe->pipe($bundle, $storage);
        }
    }
}
