<?php

namespace Nemo\Etherscan\ValueObjects;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Carbon\CarbonImmutable;
use Nemo\Etherscan\Support\Numbers;

class InternalTransaction
{
    public function __construct(
        public BigDecimal $blockNumber,
        public CarbonImmutable $timeStamp,
        public string $hash,
        // public int             $nonce,
        // public string          $blockHash,
        // public int             $transactionIndex,
        public string $from,
        public string $to,
        public BigDecimal $value,
        public BigDecimal $gas,
        // public BigDecimal      $gasPrice,
        public bool $isError,
        // public string          $receiptStatus,
        public string $input,
        public string $contractAddress,
        // public BigDecimal      $cumulativeGasUsed,
        // public BigDecimal      $gasUsed,
        // public BigDecimal      $confirmations,
        // public ?string         $methodId,
        // public ?string         $functionName,
        public string $type,
        public string $traceId,
        public string $errorCode,
    ) {
        //
    }

    /**
     * @throws MathException
     */
    public static function fromResponse(array $response): InternalTransaction
    {
        return new InternalTransaction(
            blockNumber: BigDecimal::of($response['blockNumber']),
            timeStamp: CarbonImmutable::createFromTimestamp($response['timeStamp']),
            hash: $response['hash'],
            // nonce: (int)$response["nonce"],
            // blockHash: $response["blockHash"],
            // transactionIndex: (int)$response["transactionIndex"],
            from: $response['from'],
            to: $response['to'],
            value: BigDecimal::of($response['value']),
            gas: BigDecimal::of($response['gas']),
            // gasPrice: BigDecimal::of($response["gasPrice"]),
            isError: (bool) $response['isError'],
            // receiptStatus: $response["txreceipt_status"],
            input: $response['input'],
            contractAddress: $response['contractAddress'],
            // cumulativeGasUsed: BigDecimal::of($response["cumulativeGasUsed"]),
            // gasUsed: BigDecimal::of($response["gasUsed"]),
            // confirmations: BigDecimal::of($response["confirmations"]),
            // methodId: $response["methodId"] ?? null,
            // functionName: $response["functionName"] ?? null,
            type: $response['type'],
            traceId: $response['traceId'],
            errorCode: $response['errCode'],
        );
    }

    public function resolveValue(): float
    {
        return $this->value->isGreaterThan(BigDecimal::zero()) ? Numbers::scaleToFloat($this->value, 18) : 0;
    }
}
