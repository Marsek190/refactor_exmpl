<?php

namespace Dyson\Services\Product\Logo;

interface ProductLogoFetcher
{
    /** @return string|null */
    public function fetch();
}
