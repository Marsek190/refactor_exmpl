<?php

namespace Dyson\Services\Catalog\Filters;

abstract class AbstractFilter implements Filter
{
    /** @var string[][] */
    protected $filters = [];

    /** @var FilterQueries */
    protected $filterQueries;

    /** @var string[] */
    protected $availableFilters = [];

    /**
     * @param FilterQueries $filterQueries
     */
    public function __construct(FilterQueries $filterQueries)
    {
        $this->filterQueries = $filterQueries;
    }

    /** @inheritDoc */
    public function isSatisfiedBy(array $product)
    {
        /**
         * @var string $parameter
         * @var string[] $filteredValues
         */
        foreach ($this->filterQueries as $parameter => $filteredValues) {
            if (!isset($this->filters[$parameter])) {
                continue;
            }

            /** @var string $filteredValue */
            foreach ($filteredValues as $filteredValue) {
                if (
                    !in_array(
                        $this->filters[$parameter][$filteredValue],
                        $product[$this->getFormattedProperty($parameter)]
                    )
                ) {
                    return false;
                }
            }
        }

        /**
         * @var string $parameter
         * @var string[] $properties
         */
        foreach ($this->filters as $parameter => $properties) {
            /** @var string $propertyValue */
            foreach ($product[$this->getFormattedProperty($parameter)] as $propertyValue) {
                $filter = array_search($propertyValue, $properties) ?: null;
                if ($filter !== null && !isset($this->availableFilters[$filter])) {
                    $this->availableFilters[$filter] = $filter;
                }
            }
        }

        return true;
    }

    /** @inheritDoc */
    public function getAvailableFilters()
    {
        return array_values($this->availableFilters);
    }

    /** @inheritDoc */
    public function getAllFilters()
    {
        return $this->filters;
    }

    /** @inheritDoc */
    public function getFilterQueries()
    {
        return $this->filterQueries->toArray();
    }

    /**
     * @param string $parameter
     * @return string
     */
    private function getFormattedProperty($parameter)
    {
        // todo: в будущем определенно стоит отказаться от явной зависимости нейминга свойств в битриксе
        return 'PROPERTY_' . $parameter . '_VALUE';
    }
}
