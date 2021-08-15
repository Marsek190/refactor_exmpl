<?php

namespace Dyson\Services\Product\Picture;

interface ProductPictureFetcher
{
    /** @return string|null */
    public function fetch();
}
