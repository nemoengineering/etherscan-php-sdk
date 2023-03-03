<?php

namespace Nemo\Etherscan\ValueObjects;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Nemo\Etherscan\Support\Numbers;

class ProxyTransaction
{
    public function __construct(
        public string $blockHash,
        public BigDecimal $blockNumber,
        public string $hash,
        public int $nonce,
        public int $transactionIndex,
        public string $from,
        public string $to,
        public string $input,
        public BigDecimal $value,
        public string $type,
        public array $accessList,
        public int $chainId,

        public BigDecimal $gas,
        public BigDecimal $gasPrice,
        public BigDecimal $maxFeePerGas,
        public BigDecimal $maxPriorityFeePerGas,

        public string $v,
        public string $r,
        public string $s,
    ) {
        //
    }

    /**
     * @throws MathException
     */
    public static function fromResponse(array $response): ProxyTransaction
    {
        return new ProxyTransaction(
            blockHash: $response['blockHash'],
            blockNumber: BigDecimal::of(hexdec($response['blockNumber'])),
            hash: $response['hash'],
            nonce: (int) hexdec($response['nonce']),
            transactionIndex: (int) hexdec($response['transactionIndex']),
            from: $response['from'],
            to: $response['to'],
            input: $response['input'],
            value: BigDecimal::of(hexdec($response['value'])),
            type: $response['type'],
            accessList: $response['accessList'],
            chainId: (int) hexdec($response['chainId']),
            gas: BigDecimal::of(hexdec($response['gas'])),
            gasPrice: BigDecimal::of(hexdec($response['gasPrice'])),
            maxFeePerGas: BigDecimal::of(hexdec($response['maxFeePerGas'])),
            maxPriorityFeePerGas: BigDecimal::of(hexdec($response['maxPriorityFeePerGas'])),
            v: $response['v'],
            r: $response['r'],
            s: $response['s'],
        );
    }

    public function resolveValue(): float
    {
        return $this->value->isGreaterThan(BigDecimal::zero()) ? Numbers::scaleToFloat($this->value, 18) : 0;
    }
}
