<?php

declare(strict_types=1);

namespace Aventusgroup\Google2fa\Generator;

use Aventusgroup\Google2fa\Config\Params;

class Secret
{
    public static function generateSecret($length = 16): string
    {
        $charactersLength = strlen(Params::CHARACTERS);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= Params::CHARACTERS[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}