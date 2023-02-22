<?php

namespace Nemo\Etherscan\ValueObjects;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;

class EtherBalance
{
    public function __construct(
        public string $account,
        public BigDecimal $balance,
    ) {
        //
    }

    /**
     * @throws MathException
     */
    public static function fromResponse(array $response): EtherBalance
    {
        return new EtherBalance(
            account: $response['account'],
            balance: BigDecimal::of($response['balance']),
        );
    }
}
