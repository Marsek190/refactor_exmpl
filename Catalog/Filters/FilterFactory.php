<?php

namespace Dyson\Services\Catalog\Filters;

use Dyson\Services\Catalog\Request\SectionRequest;
use Dyson\Services\Catalog\SectionMapper;

class FilterFactory
{
    private $filterParser;

    /**
     * @param FilterParser $filterParser
     */
    public function __construct(FilterParser $filterParser)
    {
        $this->filterParser = $filterParser;
    }

    /**
     * @param SectionRequest $sectionRequest
     * @return Filter
     */
    public function create(SectionRequest $sectionRequest)
    {
        $filterQueries = new FilterQueries($this->filterParser->parse());
        switch (mb_strtolower($sectionRequest->code)) {
            case 'dyson-vacuums':
                return new VacuumsFilter($filterQueries);
            case 'dyson-fans-and-heaters':
                return new FansFilter($filterQueries);
            case 'accessories':
                return new AccessoriesFilter($sectionRequest);
            default:
                return new DefaultFilter();
        }
    }
}
