<?php

namespace Dyson\Services\Product\Handler;

use Dyson\Base\Db\Connection;
use Dyson\Services\Catalog\SectionMapper;
use Dyson\Services\Product\Bundles\BundleDataProvider;
use Dyson\Services\Product\Bundles\BundleFactory;
use Dyson\Services\Product\Bundles\Pipes\PipelineFactory;

class ProductHandlerFactory
{
    private $bundleDataProvider;
    private $pipelineFactory;

    public function __construct()
    {
        $sectionMapper = new SectionMapper();
        $this->bundleDataProvider = new BundleDataProvider(
            new Connection(),
            new BundleFactory($sectionMapper)
        );
        $this->pipelineFactory = new PipelineFactory();
    }

    /** @return BasketDisabledProductsHandler */
    public function createBasketDisabledProductsHandler()
    {
        return new BasketDisabledProductsHandler(
            $this->pipelineFactory,
            $this->bundleDataProvider
        );
    }

    /** @return FeedDisabledProductsHandler */
    public function createFeedDisabledProductsHandler()
    {
        return new FeedDisabledProductsHandler(
            $this->pipelineFactory,
            $this->bundleDataProvider
        );
    }

    /** @return CatalogDisabledProductsHandler */
    public function createCatalogDisabledProductsHandler()
    {
        return new CatalogDisabledProductsHandler(
            $this->pipelineFactory,
            $this->bundleDataProvider
        );
    }
}
