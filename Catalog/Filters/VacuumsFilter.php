<?php

namespace Dyson\Services\Catalog\Filters;

class VacuumsFilter extends AbstractFilter
{
    /** @inheriDoc */
    protected $filters = [
        'HOME_SIZE' => [
            'small' => '1 комната',
            'medium' => '2-3 комнаты',
            'big' => 'более 3х комнат'
        ],
        'TYPE_COVER' => [
            'carpet' => 'Ковровое покрытие, кроме ковролина',
            'wood' => 'Твердое покрытие',
            'delicate' => 'Деликатные покрытия, в том числе паркет',
            'carpeting' => 'Ковролин'
        ],
        'FOR' => [
            'animals' => 'Владельцев домашних животных',
            'allergy' => 'Людей, склонных к аллергии',
            'cars' => 'Владельцев автомобилей'
        ]
    ];
}
