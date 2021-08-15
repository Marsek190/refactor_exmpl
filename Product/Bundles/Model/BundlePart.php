<?php

namespace Dyson\Services\Product\Bundles\Model;

class BundlePart
{
    private $id;
    private $sectionId;
    private $isActive;
    private $isAccessory;
    private $bashRemains;
    private $tpRemains;

    /**
     * @param int $id
     * @param int $sectionId
     * @param bool $isActive
     * @param bool $isAccessory
     * @param Remains $bashRemains
     * @param Remains $tpRemains
     */
    public function __construct($id, $sectionId, $isActive, $isAccessory, Remains $bashRemains, Remains $tpRemains)
    {
        $this->id = $id;
        $this->sectionId = $sectionId;
        $this->isActive = $isActive;
        $this->isAccessory = $isAccessory;
        $this->bashRemains = $bashRemains;
        $this->tpRemains = $tpRemains;
    }

    /** @return int */
    public function id()
    {
        return $this->id;
    }

    /** @return int */
    public function sectionId()
    {
        return $this->sectionId;
    }

    /** @return bool */
    public function isActive()
    {
        return $this->isActive;
    }

    /** @return bool */
    public function isAccessory()
    {
        return $this->isAccessory;
    }

    /** @return Remains */
    public function bashRemains()
    {
        return $this->bashRemains;
    }

    /** @return Remains */
    public function tpRemains()
    {
        return $this->tpRemains;
    }
}
