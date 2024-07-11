<?php
declare(strict_types=1);

namespace Aventusgroup\Google2fa\Service;

use Aventusgroup\Google2fa\Generator\Qr;
use Aventusgroup\Google2fa\Generator\Secret;

class TwoFactor
{
    public static function generateSecretKey(): string
    {
        return Secret::generateSecret();
    }

    public static function generateQr($secret, $issuer, $accountName): string
    {
        return Qr::generateQr($secret, $issuer, $accountName);
    }

    public static function checkCode($code, $secret): bool
    {
        return (string)$code === TOTP::getCode($secret);
    }
}