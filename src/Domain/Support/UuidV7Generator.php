<?php

namespace App\Domain\Support;

class UuidV7Generator
{
    public static function fromBase(string $digits): string
    {
        $map = [
            '' => '0123456789',
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
        ];
        $base = \strlen($map['']);
        $count = \strlen($digits);
        $bytes = [];

        while ($count) {
            $quotient = [];
            $remainder = 0;

            for ($i = 0; $i !== $count; ++$i) {
                $carry = ($bytes ? $digits[$i] : $map[$digits[$i]]) + $remainder * $base;

                if (\PHP_INT_SIZE >= 8) {
                    $digit = $carry >> 16;
                    $remainder = $carry & 0xFFFF;
                } else {
                    $digit = $carry >> 8;
                    $remainder = $carry & 0xFF;
                }

                if ($digit || $quotient) {
                    $quotient[] = $digit;
                }
            }

            $bytes[] = $remainder;
            $count = \count($digits = $quotient);
        }

        return pack(\PHP_INT_SIZE >= 8 ? 'n*' : 'C*', ...array_reverse($bytes));
    }

    public static function generate(): string
    {
        $time = microtime(false);
        $time = substr($time, 11).substr($time, 2, 3);

        $rand = unpack('n*', random_bytes(16));
        $rand[1] &= 0x03FF;

        if (\PHP_INT_SIZE >= 8) {
            $time = dechex($time);
        } else {
            $time = bin2hex(self::fromBase($time));
        }

        return substr_replace(sprintf('%012s-%04x-%04x-%04x%04x%04x',
            $time,
            0x7000 | ($rand[1] << 2) | ($rand[2] >> 14),
            0x8000 | ($rand[2] & 0x3FFF),
            $rand[3],
            $rand[4],
            $rand[5],
        ), '-', 8, 0);
    }
}