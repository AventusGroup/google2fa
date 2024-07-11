<?php

declare(strict_types=1);

namespace Aventusgroup\Google2fa\Generator;

use Aventusgroup\Google2fa\Config\Params;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class Qr
{
    public static function generateQr($secret, $issuer = 'AventusGroup', $accountName = 'Test'): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);

        $data = sprintf(
            "otpauth://totp/%s:%s?secret=%s&issuer=%s&algorithm=%s&digits=%s&period=%s",
            $issuer,
            $accountName,
            $secret,
            $issuer,
            Params::ALGORITHM,
            Params::CODE_LENGTH,
            Params::TIME
        );

        $filename = sprintf("files\%s_%s.png", $issuer, $accountName);

        $writer->writeFile($data, $filename);

        $content = file_get_contents($filename);
        unlink($filename);

        return base64_encode($content);
    }
}