<?php

namespace Dyson\Services\Product\Handler;

use Dyson\Services\Product\Bundles\BundleDataProvider;
use Dyson\Services\Product\Bundles\Pipes\PipelineFactory;
use Dyson\Services\Product\Storage\DisabledProductsStorageInMemory;
use Dyson\Services\Product\Storage\DisabledProductsStorage;

class CatalogDisabledProductsHandler
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

    /**
     * @param int[] $productIds
     * @return DisabledProductsStorage
     */
    public function handle(array $productIds)
    {
        $bundles = $this->bundleDataProvider->findByProductIds($productIds);
        $storage = new DisabledProductsStorageInMemory();
        $pipeline = $this->pipelineFactory->createCatalogPipeline();
        foreach ($bundles as $bundle) {
            $pipeline->pipe($bundle, $storage);
        }

        return $storage;
    }
}
