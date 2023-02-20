<?php

namespace Nemo\Etherscan\ValueObjects;

use Brick\Math\BigInteger;
use Brick\Math\Exception\MathException;

class EtherBalance
{
    public function __construct(
        public string $account,
        public BigInteger $balance,
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
            balance: BigInteger::of($response['balance']),
        );
    }
}
