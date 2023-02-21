<?php

namespace Nemo\Etherscan\ValueObjects;

use Brick\Math\BigInteger;
use Brick\Math\Exception\MathException;
use Carbon\CarbonImmutable;
use Nemo\Etherscan\Support\Numbers;

class NormalTransaction
{
    public function __construct(
        public BigInteger $blockNumber,
        public CarbonImmutable $timeStamp,
        public string $hash,
        public int $nonce,
        public string $blockHash,
        public int $transactionIndex,
        public string $from,
        public string $to,
        public BigInteger $value,
        public BigInteger $gas,
        public BigInteger $gasPrice,
        public bool $isError,
        public string $receiptStatus,
        public string $input,
        public string $contractAddress,
        public BigInteger $cumulativeGasUsed,
        public BigInteger $gasUsed,
        public BigInteger $confirmations,
        public ?string $methodId,
        public ?string $functionName,
    ) {
        //
    }

    /**
     * @throws MathException
     */
    public static function fromResponse(array $response): NormalTransaction
    {
        return new NormalTransaction(
            blockNumber: BigInteger::of($response['blockNumber']),
            timeStamp: CarbonImmutable::createFromTimestamp($response['timeStamp']),
            hash: $response['hash'],
            nonce: (int) $response['nonce'],
            blockHash: $response['blockHash'],
            transactionIndex: (int) $response['transactionIndex'],
            from: $response['from'],
            to: $response['to'],
            value: BigInteger::of($response['value']),
            gas: BigInteger::of($response['gas']),
            gasPrice: BigInteger::of($response['gasPrice']),
            isError: (bool) $response['isError'],
            receiptStatus: $response['txreceipt_status'],
            input: $response['input'],
            contractAddress: $response['contractAddress'],
            cumulativeGasUsed: BigInteger::of($response['cumulativeGasUsed']),
            gasUsed: BigInteger::of($response['gasUsed']),
            confirmations: BigInteger::of($response['confirmations']),
            methodId: $response['methodId'] ?? null,
            functionName: $response['functionName'] ?? null,
        );
    }

    public function resolveValue(): float
    {
        return $this->value->isGreaterThan(BigInteger::zero()) ? Numbers::scaleToFloat($this->value, 18) : 0;
    }
}
