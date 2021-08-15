<?php

namespace Dyson\Services\Catalog\Filters;

class FansFilter extends AbstractFilter
{
    /** @inheriDoc */
    protected $filters = [
        'CLIMATE_PROPERTIES' => [
            'cleaning' => 'Очищение воздуха',
            'moisturizing' => 'Увлажнение воздуха',
            'heating' => 'Функция обогрева',
            'fan' => 'Функция вентилятора',
        ]
    ];
}
