<?php

namespace Dyson\Services\Product\Storage;

class DisabledProductsStorageInMemory implements DisabledProductsStorage
{
    /** @var int[] */
    private $disabledAvailabilityIds = [];

    /** @var int[] */
    private $disabledVisibilityIds = [];

    /** @inheritDoc */
    public function disableVisibility($productId)
    {
        if (!isset($this->disabledVisibilityIds[$productId])) {
            $this->disableAvailability($productId);
            $this->disabledVisibilityIds[$productId] = true;
        }
    }

    /** @inheritDoc */
    public function disableAvailability($productId)
    {
        if (!isset($this->disabledAvailabilityIds[$productId])) {
            $this->disabledAvailabilityIds[$productId] = true;
        }
    }

    /** @inheritDoc */
    public function isAvailable($productId)
    {
        return !isset($this->disabledAvailabilityIds[$productId]);
    }

    /** @inheritDoc */
    public function isVisible($productId)
    {
        return !isset($this->disabledVisibilityIds[$productId]);
    }
}
