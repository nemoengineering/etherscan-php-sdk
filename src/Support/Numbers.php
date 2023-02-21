<?php

namespace Nemo\Etherscan\Support;

use Brick\Math\BigInteger;

class Numbers
{
    public static function scale(BigInteger $balance, int $decimals): BigInteger
    {
        $exponent = BigInteger::of(10 ** $decimals);

        return $balance->dividedBy($exponent);
    }

    public static function scaleToFloat(BigInteger $balance, int $decimals): float
    {
        return self::scale($balance, $decimals)->toFloat();
    }
}
