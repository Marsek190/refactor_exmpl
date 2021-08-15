<?php

namespace Dyson\Services\Product\Bundles;

use PDO;
use Dyson\Base\Db\Connection;
use Dyson\Services\Product\Bundles\Model\Bundle;

class BundleDataProvider
{
    private $connection;
    private $bundleFactory;

    /**
     * @param Connection $connection
     * @param BundleFactory $bundleFactory
     */
    public function __construct(Connection $connection, BundleFactory $bundleFactory)
    {
        $this->connection = $connection;
        $this->bundleFactory = $bundleFactory;
    }

    /** @return Bundle[] */
    public function findAll()
    {
        $query = '
            SELECT
                bundle_mp.IBLOCK_ELEMENT_ID AS bundleId,
                bundle_mp.VALUE AS bundlePartId,
                bundle.ACTIVE AS bundleActive,
                bundle_part.ACTIVE AS bundlePartActive,
                bundle_part_remains.TP_STOCK AS tpQuantity,
                bundle_part_remains.PS_BASH_STOCK AS bashQuantity,
                bundle_part_section.ID AS sectionId,
                IFNULL(bundle_part_sp.PROPERTY_9027, 1) AS bundlePartRemainsLimit
            FROM b_iblock_element bundle
            INNER JOIN b_iblock_section bundle_section ON bundle_section.ID = bundle.IBLOCK_SECTION_ID
            INNER JOIN b_iblock_element_prop_s35 bundle_sp ON bundle_sp.IBLOCK_ELEMENT_ID = bundle.ID
            INNER JOIN b_iblock_element_prop_m35 bundle_mp ON bundle_mp.IBLOCK_ELEMENT_ID = bundle.ID
                AND bundle_mp.IBLOCK_PROPERTY_ID = ?
            INNER JOIN b_iblock_element bundle_part ON bundle_part.ID = bundle_mp.VALUE
            INNER JOIN b_iblock_section bundle_part_section ON bundle_part_section.ID = bundle_part.IBLOCK_SECTION_ID
            INNER JOIN b_iblock_element_prop_s35 bundle_part_sp ON bundle_part_sp.IBLOCK_ELEMENT_ID = bundle_mp.VALUE
            INNER JOIN D_COMBINED_STOCKS bundle_part_remains ON bundle_part_remains.SKU = bundle_part_sp.PROPERTY_4449
            WHERE (
                bundle_sp.PROPERTY_4449 IS NOT NULL
            )
            ORDER BY bundle.ID
        ';
        $queryParams = [
            $this->getIncomingProductsPropertyId(),
        ];
        $stmt = $this->connection->query($query, $queryParams);
        $bundleParts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->bundleFactory->createBundles($bundleParts);
    }

    /**
     * @param int $productId
     * @return Bundle|null
     */
    public function findByProductId($productId)
    {
        $query = '
            SELECT
                bundle_mp.IBLOCK_ELEMENT_ID AS bundleId,
                bundle_mp.VALUE AS bundlePartId,
                bundle.ACTIVE AS bundleActive,
                bundle_part.ACTIVE AS bundlePartActive,
                bundle_part_remains.TP_STOCK AS tpQuantity,
                bundle_part_remains.PS_BASH_STOCK AS bashQuantity,
                bundle_part_section.ID AS sectionId,
                IFNULL(bundle_part_sp.PROPERTY_9027, 1) AS bundlePartRemainsLimit
            FROM b_iblock_element bundle
            INNER JOIN b_iblock_section bundle_section ON bundle_section.ID = bundle.IBLOCK_SECTION_ID
            INNER JOIN b_iblock_element_prop_s35 bundle_sp ON bundle_sp.IBLOCK_ELEMENT_ID = bundle.ID
            INNER JOIN b_iblock_element_prop_m35 bundle_mp ON bundle_mp.IBLOCK_ELEMENT_ID = bundle.ID
                AND bundle_mp.IBLOCK_PROPERTY_ID = ?
            INNER JOIN b_iblock_element bundle_part ON bundle_part.ID = bundle_mp.VALUE
            INNER JOIN b_iblock_section bundle_part_section ON bundle_part_section.ID = bundle_part.IBLOCK_SECTION_ID
            INNER JOIN b_iblock_element_prop_s35 bundle_part_sp ON bundle_part_sp.IBLOCK_ELEMENT_ID = bundle_mp.VALUE
            INNER JOIN D_COMBINED_STOCKS bundle_part_remains ON bundle_part_remains.SKU = bundle_part_sp.PROPERTY_4449
            WHERE (
                bundle.ID = ? AND
                bundle_sp.PROPERTY_4449 IS NOT NULL
            )
            ORDER BY bundle.ID
        ';
        $queryParams = [
            $this->getIncomingProductsPropertyId(),
            $productId,
        ];
        $stmt = $this->connection->query($query, $queryParams);
        $bundleParts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($bundleParts) === 0) {
            return null;
        }

        $bundles = $this->bundleFactory->createBundles($bundleParts);

        return $bundles[0];
    }

    /**
     * @param int[] $productIds
     * @return Bundle[]
     */
    public function findByProductIds(array $productIds)
    {
        if (count($productIds) === 0) {
            return [];
        }

        $query = '
            SELECT
                bundle_mp.IBLOCK_ELEMENT_ID AS bundleId,
                bundle_mp.VALUE AS bundlePartId,
                bundle.ACTIVE AS bundleActive,
                bundle_part.ACTIVE AS bundlePartActive,
                bundle_part_remains.TP_STOCK AS tpQuantity,
                bundle_part_remains.PS_BASH_STOCK AS bashQuantity,
                bundle_part_section.ID AS sectionId,
                IFNULL(bundle_part_sp.PROPERTY_9027, 1) AS bundlePartRemainsLimit
            FROM b_iblock_element bundle
            INNER JOIN b_iblock_section bundle_section ON bundle_section.ID = bundle.IBLOCK_SECTION_ID
            INNER JOIN b_iblock_element_prop_s35 bundle_sp ON bundle_sp.IBLOCK_ELEMENT_ID = bundle.ID
            INNER JOIN b_iblock_element_prop_m35 bundle_mp ON bundle_mp.IBLOCK_ELEMENT_ID = bundle.ID
                AND bundle_mp.IBLOCK_PROPERTY_ID = ?
            INNER JOIN b_iblock_element bundle_part ON bundle_part.ID = bundle_mp.VALUE
            INNER JOIN b_iblock_section bundle_part_section ON bundle_part_section.ID = bundle_part.IBLOCK_SECTION_ID
            INNER JOIN b_iblock_element_prop_s35 bundle_part_sp ON bundle_part_sp.IBLOCK_ELEMENT_ID = bundle_mp.VALUE
            INNER JOIN D_COMBINED_STOCKS bundle_part_remains ON bundle_part_remains.SKU = bundle_part_sp.PROPERTY_4449
            WHERE (
                bundle.ID IN (' . $this->getPlaceholdersForArray($productIds) . ') AND
                bundle_sp.PROPERTY_4449 IS NOT NULL
            )
            ORDER BY bundle.ID
        ';
        $queryParams = array_merge([
            $this->getIncomingProductsPropertyId(),
        ], $productIds);
        $stmt = $this->connection->query($query, $queryParams);
        $bundleParts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->bundleFactory->createBundles($bundleParts);
    }

    /**
     * @param array $data
     * @return string
     */
    private function getPlaceholdersForArray(array $data)
    {
        return implode(',', array_fill(0, count($data), '?'));
    }

    /** @return int */
    private function getIncomingProductsPropertyId()
    {
        return 11837;
    }
}
