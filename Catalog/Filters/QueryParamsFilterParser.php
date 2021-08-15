<?php

namespace Dyson\Services\Catalog\Filters;

use Psr\Http\Message\ServerRequestInterface;

class QueryParamsFilterParser implements FilterParser
{
    private $httpRequest;

    /**
     * @param ServerRequestInterface $httpRequest
     */
    public function __construct(ServerRequestInterface $httpRequest)
    {
        $this->httpRequest = $httpRequest;
    }

    /** @inheritDoc */
    public function parse()
    {
        $queryParams = $this->httpRequest->getQueryParams();
        $requestBody = $this->httpRequest->getParsedBody();
        $data = isset($requestBody['data']) ? $requestBody['data'] : [];

        $filterQueries = [];
        foreach ($this->getAvailableFilterQueries() as $filter) {
            if (isset($data[$filter])) {
                $filterQueries[$filter] = $data[$filter];
            } else if (isset($queryParams[$filter])) {
                $filterQueries[$filter] = $queryParams[$filter];
            }
        }

        return $filterQueries;
    }

    /** @return string[] */
    private function getAvailableFilterQueries()
    {
        return [
            'home_size',
            'type_cover',
            'for',
            'climate_properties',
        ];
    }
}
