<?php

namespace Dyson\Services\Product\Handler;

use Dyson\Services\Product\Bundles\BundleDataProvider;
use Dyson\Services\Product\Bundles\Pipes\PipelineFactory;
use Dyson\Services\Product\Storage\DisabledProductsStorage;
use Dyson\Services\Product\Storage\DisabledProductsStorageInMemory;

class FeedDisabledProductsHandler
{
    private $pipelineFactory;
    private $bundleDataProvider;

    /**
     * @param PipelineFactory $pipelineFactory
     * @param BundleDataProvider $bundleDataProvider
     */
    public function __construct(PipelineFactory $pipelineFactory, BundleDataProvider $bundleDataProvider)
    {
        $this->pipelineFactory = $pipelineFactory;
        $this->bundleDataProvider = $bundleDataProvider;
    }

    /** @return DisabledProductsStorage */
    public function handle()
    {
        $bundles = $this->bundleDataProvider->findAll();
        $storage = new DisabledProductsStorageInMemory();
        $pipeline = $this->pipelineFactory->createFeedPipeline();
        foreach ($bundles as $bundle) {
            $pipeline->pipe($bundle, $storage);
        }

        return $storage;
    }
}
