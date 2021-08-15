<?php

namespace Dyson\Services\Product\Bundles\Model;

class Bundle
{
    private $id;
    private $sectionId;
    private $isHairDryer;
    private $isActive;
    private $parts;

    /**
     * @param int $id
     * @param int $sectionId
     * @param bool $isHairDryer
     * @param bool $isActive
     * @param BundlePart[] $parts
     */
    public function __construct($id, $sectionId, $isHairDryer, $isActive, BundlePart ...$parts)
    {
        $this->id = $id;
        $this->sectionId = $sectionId;
        $this->isHairDryer = $isHairDryer;
        $this->isActive = $isActive;
        $this->parts = $parts;
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
    public function isHairDryer()
    {
        return $this->isHairDryer;
    }

    /** @return bool */
    public function isActive()
    {
        return $this->isActive;
    }

    /** @return BundlePart[] */
    public function parts()
    {
        return $this->parts;
    }
}
