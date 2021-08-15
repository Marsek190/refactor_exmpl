<?php

namespace Dyson\Services\Catalog\Filters;

use Dyson\Services\Catalog\Request\SectionRequest;

class AccessoriesFilter implements Filter
{
    private $sectionRequest;

    /**
     * @param SectionRequest $sectionRequest
     */
    public function __construct(SectionRequest $sectionRequest)
    {
        $this->sectionRequest = $sectionRequest;
    }

    /** @inheritDoc */
    public function isSatisfiedBy(array $product)
    {
        if ($this->sectionRequest->accessoryId !== null) {
            $relatedSections = $product['SECTIONS'];
            $accessoryId = $this->sectionRequest->accessoryId;
            $rootId = $this->sectionRequest->rootId;

            if ((int) $product['IBLOCK_SECTION_ID'] === $accessoryId) {
                return true;
            }

            if (in_array($accessoryId, $relatedSections) || in_array($rootId, $relatedSections)) {
                return true;
            }
        }

        return false;
    }

    /** @inheritDoc */
    public function getAvailableFilters()
    {
        return [];
    }

    /** @inheritDoc */
    public function getAllFilters()
    {
        return [];
    }

    /** @inheritDoc */
    public function getFilterQueries()
    {
        return [];
    }
}
