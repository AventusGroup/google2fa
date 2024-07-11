<?php

declare(strict_types=1);

namespace Aventusgroup\Google2fa\Service;

use Aventusgroup\Google2fa\Config\Params;

class TOTP
{
    public static function getCode($secret): string
    {
        $timeSlice = floor(time() / Params::TIME);
        $secretKey = self::base32Decode($secret);

        $time = chr(0).chr(0).chr(0).chr(0).pack('N*', $timeSlice);
        $hm = hash_hmac(Params::ALGORITHM, $time, $secretKey, true);
        $offset = ord(substr($hm, -1)) & 0x0F;
        $hashPart = substr($hm, $offset, 4);

        $value = unpack('N', $hashPart)[1];
        $value = $value & 0x7FFFFFFF;
        $value = $value % 1000000;

        return str_pad((string)$value, Params::CODE_LENGTH, '0', STR_PAD_LEFT);
    }

    private static function base32Decode($base32)
    {
        $base32chars = Params::CHARACTERS;
        $base32charsFlipped = array_flip(str_split($base32chars));
        $paddingCharCount = substr_count($base32, '=');
        $allowedValues = [6, 4, 3, 1, 0];
        if (!in_array($paddingCharCount, $allowedValues)) return false;
        for ($i = 0; $i < 4; $i++) {
            if ($paddingCharCount == $allowedValues[$i] &&
                substr($base32, -( $allowedValues[$i])) != str_repeat('=', $allowedValues[$i])) return false;
        }
        $base32 = str_replace('=', '', $base32);
        $base32 = str_split($base32);
        $binaryString = '';
        for ($i = 0; $i < count($base32); $i = $i + 8) {
            $x = '';
            if (!in_array($base32[$i], str_split($base32chars))) return false;
            for ($j = 0; $j < 8; $j++) {
                $x .= str_pad(base_convert((string)$base32charsFlipped[$base32[$i + $j]], 10, 2), 5, '0', STR_PAD_LEFT);
            }
            $eightBits = str_split($x, 8);
            for ($z = 0; $z < count($eightBits); $z++) {
                $binaryString .= chr((int)base_convert($eightBits[$z], 2, 10));
            }
        }
        return $binaryString;
    }
}