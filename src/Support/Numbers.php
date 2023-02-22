<?php

namespace Nemo\Etherscan\Support;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

class Numbers
{
    public static function scale(BigDecimal $balance, int $decimals): BigDecimal
    {
        $exponent = BigDecimal::of(10 ** $decimals);

        return $balance->dividedBy($exponent, 2, RoundingMode::DOWN);
    }

    public static function scaleToFloat(BigDecimal $balance, int $decimals): float
    {
        return self::scale($balance, $decimals)->toFloat();
    }
}
