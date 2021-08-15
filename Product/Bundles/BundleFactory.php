<?php

namespace Dyson\Services\Product\Bundles;

use Dyson\Services\Catalog\SectionMapper;
use Dyson\Services\Product\Bundles\Model\Bundle;
use Dyson\Services\Product\Bundles\Model\BundlePart;
use Dyson\Services\Product\Bundles\Model\Remains;

class BundleFactory
{
    private $sectionMapper;

    /**
     * @param SectionMapper $sectionMapper
     */
    public function __construct(SectionMapper $sectionMapper)
    {
        $this->sectionMapper = $sectionMapper;
    }

    /**
     * @param array[] $bundleParts
     * @return Bundle[]
     */
    public function createBundles(array $bundleParts)
    {
        $bundleGroupParts = [];
        /** @var array<int, bool> $bundleActivityMap */
        $bundleActivityMap = [];
        foreach ($bundleParts as $bundlePart) {
            $bundleId = (int) $bundlePart['bundleId'];
            $bashQuantity = (int) $bundlePart['bashQuantity'];
            $tpQuantity = (int) $bundlePart['tpQuantity'];
            $sectionId = (int) $bundlePart['sectionId'];
            $remainsLimit = (int) $bundlePart['bundlePartRemainsLimit'];
            $bundlePartId = (int) $bundlePart['bundlePartId'];

            $bundleGroupParts[$bundleId][] = new BundlePart(
                $bundlePartId,
                $sectionId,
                $bundlePart['bundlePartActive'] === 'Y',
                $this->sectionMapper->getAccessoriesId() === $sectionId,
                new Remains($bashQuantity >= 0 ? $bashQuantity : 0, $remainsLimit),
                new Remains($tpQuantity >= 0 ? $tpQuantity : 0, $remainsLimit)
            );

            $bundleActivityMap[$bundleId] = $bundlePart['bundleActive'] === 'Y';
        }

        $bundles = [];
        /**
         * @var int $bundleId
         * @var BundlePart[] $bundleParts
         */
        foreach ($bundleGroupParts as $bundleId => $bundleParts) {
            $sectionId = $bundleParts[0]->sectionId();
            $bundles[] = new Bundle(
                $bundleId,
                $sectionId,
                $this->sectionMapper->getHairDryersId() === $sectionId,
                $bundleActivityMap[$bundleId],
                ...$bundleParts
            );
        }

        return $bundles;
    }
}
