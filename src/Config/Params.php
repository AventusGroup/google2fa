<?php

declare(strict_types=1);

namespace Aventusgroup\Google2fa\Config;

class Params
{
    public const TIME = 30;
    public const ALGORITHM = 'SHA1';
    public const CHARACTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    public const CODE_LENGTH = 6;
}
