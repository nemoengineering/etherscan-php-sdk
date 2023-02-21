<?php

namespace Nemo\Etherscan\ValueObjects;

use Brick\Math\BigInteger;
use Brick\Math\Exception\MathException;
use Carbon\CarbonImmutable;

class ERC721Transfer
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
        // public BigInteger $value,
        public BigInteger $gas,
        public BigInteger $gasPrice,
        // public bool            $isError,
        // public string          $receiptStatus,
        // public string          $input, FIXME deprecated
        public string $contractAddress,
        public BigInteger $cumulativeGasUsed,
        public BigInteger $gasUsed,
        public BigInteger $confirmations,
        // public ?string         $methodId,
        // public ?string         $functionName,
        public string $tokenId,
        public string $tokenName,
        public string $tokenSymbol,
        public int $tokenDecimal,
    ) {
        //
    }

    /**
     * @throws MathException
     */
    public static function fromResponse(array $response): ERC721Transfer
    {
        return new ERC721Transfer(
            blockNumber: BigInteger::of($response['blockNumber']),
            timeStamp: CarbonImmutable::createFromTimestamp($response['timeStamp']),
            hash: $response['hash'],
            nonce: (int) $response['nonce'],
            blockHash: $response['blockHash'],
            transactionIndex: (int) $response['transactionIndex'],
            from: $response['from'],
            to: $response['to'],
            // value: BigInteger::of($response['value']),
            gas: BigInteger::of($response['gas']),
            gasPrice: BigInteger::of($response['gasPrice']),
            // isError: (bool)$response["isError"],
            // receiptStatus: $response["txreceipt_status"],
            // input: $response["input"],
            contractAddress: $response['contractAddress'],
            cumulativeGasUsed: BigInteger::of($response['cumulativeGasUsed']),
            gasUsed: BigInteger::of($response['gasUsed']),
            confirmations: BigInteger::of($response['confirmations']),
            // methodId: $response["methodId"] ?? null,
            // functionName: $response["functionName"] ?? null,
            tokenId: $response['tokenID'],
            tokenName: $response['tokenName'],
            tokenSymbol: $response['tokenSymbol'],
            tokenDecimal: (int) $response['tokenDecimal'],
        );
    }
}
