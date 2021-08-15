<?php

namespace Dyson\Services\Product\Bundles\Pipes;

use Dyson\Services\Product\Bundles\HasRemainsBundleChecker;

class PipelineFactory
{
    private $remainsChecker;

    public function __construct()
    {
        $this->remainsChecker = new HasRemainsBundleChecker();
    }

    /** @return BundlePipeline */
    public function createBasketPipeline()
    {
        $pipes = [
            new AvailabilityBundlePipe($this->remainsChecker),
        ];

        return new BundlePipeline(...$pipes);
    }

    /** @return BundlePipeline */
    public function createCatalogPipeline()
    {
        $pipes = [
            new VisibilityBundlePipe($this->remainsChecker),
            new AvailabilityBundlePipe($this->remainsChecker),
        ];

        return new BundlePipeline(...$pipes);
    }

    /** @return BundlePipeline */
    public function createFeedPipeline()
    {
        return $this->createBasketPipeline();
    }
}
