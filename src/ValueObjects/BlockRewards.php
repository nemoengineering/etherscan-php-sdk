<?php

namespace Nemo\Etherscan\ValueObjects;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Carbon\CarbonImmutable;

class BlockRewards
{
    public function __construct(
        public BigDecimal $blockNumber,
        public CarbonImmutable $timeStamp,
        public string $blockMiner,
        public BigDecimal $blockReward,
        public array $uncles,
        public BigDecimal $uncleInclusionReward,
    ) {
        //
    }

    /**
     * @throws MathException
     */
    public static function fromResponse(array $response): BlockRewards
    {
        return new BlockRewards(
            blockNumber: BigDecimal::of($response['blockNumber']),
            timeStamp: CarbonImmutable::createFromTimestamp($response['timeStamp']),
            blockMiner: $response['blockMiner'],
            blockReward: BigDecimal::of($response['blockReward']),
            uncles: $response['uncles'],
            uncleInclusionReward: BigDecimal::of($response['uncleInclusionReward']),
        );
    }
}
