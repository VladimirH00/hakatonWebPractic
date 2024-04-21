<?php

namespace App\Extensions\DataProviders;

use App\Extensions\DataProviders\Interfaces\ProviderInterface;

class FormatterResponse
{
    public static function format(ProviderInterface $content)
    {
        return [
            'data' => $content->getData(),
        ];
    }
}
