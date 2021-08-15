<?php

namespace Dyson\Services\Product\Storage;

interface DisabledProductsStorage
{
    /**
     * @param int $productId
     * @return void
     */
    public function disableVisibility($productId);

    /**
     * @param int $productId
     * @return void
     */
    public function disableAvailability($productId);

    /**
     * @param int $productId
     * @return bool
     */
    public function isAvailable($productId);

    /**
     * @param int $productId
     * @return bool
     */
    public function isVisible($productId);
}
