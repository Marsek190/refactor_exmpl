<?php

namespace Dyson\Services\Catalog\Request;

class SorterRequest
{
    /** @var string|null */
    private $orderBy = null;

    /** @var bool|null */
    private $asc = null;

    private $orderByAllowed = ['price', 'new', 'popularity'];
    private $ascAllowed = ['up', 'down'];

    /**
     * @param string $query
     */
    public function __construct($query)
    {
        if (empty($query) || !is_string($query)) {
            return;
        }

        parse_str($query, $reslt);

        if (
            !empty($reslt['order']) &&
            strpos($reslt['order'], '_') !== false
        ) {
            $parts = explode('_', $reslt['order'], 2) ?: [];

            unset($reslt);

            if (count($parts) !== 2) {
                return;
            }

            list($orderBy, $asc) = $parts;

            $this->setOrderBy($orderBy);
            $this->setAsc($asc);
        }
    }

    /** @return bool */
    public function orderByPrice()
    {
        return $this->orderBy === 'price';
    }

    /** @return bool */
    public function orderByNewest()
    {
        return $this->orderBy === 'new';
    }

    /** @return bool */
    public function orderByPopularity()
    {
        return $this->orderBy === 'popularity';
    }

    /** @return bool|null */
    public function asc()
    {
        return $this->asc;
    }

    /** @param string $orderBy */
    public function setOrderBy($orderBy)
    {
        if (in_array($orderBy, $this->orderByAllowed)) {
            $this->orderBy = $orderBy;
        }
    }

    /** @param string $asc */
    public function setAsc($asc)
    {
        if (in_array($asc, $this->ascAllowed)) {
            $this->asc = $asc === 'up';
        }
    }

    /** @return string */
    public function getOrderBy()
    {
        if ($this->orderBy === null) {
            return 'new_up';
        }

        return sprintf('%s_%s', $this->orderBy, $this->asc ? 'up' : 'down');
    }
}
