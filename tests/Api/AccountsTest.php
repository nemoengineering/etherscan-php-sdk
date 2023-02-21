<?php

namespace Nemo\Etherscan\Tests\Api;

use Brick\Math\BigInteger;
use Carbon\CarbonImmutable;
use Nemo\Etherscan\Etherscan;
use Nemo\Etherscan\Support\Chain;
use Nemo\Etherscan\Tests\TestCase;
use Nemo\Etherscan\ValueObjects\ERC1155Transfer;
use Nemo\Etherscan\ValueObjects\ERC20Transfer;
use Nemo\Etherscan\ValueObjects\ERC721Transfer;
use Nemo\Etherscan\ValueObjects\InternalTransaction;
use Nemo\Etherscan\ValueObjects\NormalTransaction;

class AccountsTest extends TestCase
{
    public function testGetNormalTransactionsByAddress()
    {
        // given
        $mockedResponse = file_get_contents(__DIR__.'/../Mocks/getNormalTransactionsByAddress.json');
        $handler = $this->mockJsonResponse($mockedResponse);
        $client = $this->clientWithHandler($handler);
        $etherscan = new Etherscan(Chain::Ethereum, 'secret', $client);

        // when
        $result = $etherscan->accounts()->getNormalTransactionsByAddress(
            address: '0x648aA14e4424e0825A5cE739C8C68610e143FB79',
            startBlock: 15500000,
            endBlock: 16600000,
        );

        // then
        /** @var NormalTransaction $first */
        $first = $result[0];

        $this->assertEquals(BigInteger::of(15521222), $first->blockNumber);
        $this->assertEquals(CarbonImmutable::parse('2022-09-12 13:58:12.000000'), $first->timeStamp);
        $this->assertEquals(846, $first->nonce);
        $this->assertEquals('1', $first->receiptStatus);
        $this->assertEquals(null, $first->contractAddress);
    }

    public function testGetInternalTransactionsByAddress()
    {
        // given
        $mockedResponse = file_get_contents(__DIR__.'/../Mocks/getInternalTransactionsByAddress.json');
        $handler = $this->mockJsonResponse($mockedResponse);
        $client = $this->clientWithHandler($handler);
        $etherscan = new Etherscan(Chain::Ethereum, 'secret', $client);

        // when
        $result = $etherscan->accounts()->getInternalTransactionsByAddress(
            address: '0x648aA14e4424e0825A5cE739C8C68610e143FB79',
            startBlock: 15500000,
            endBlock: 16600000,
        );

        // then
        /** @var InternalTransaction $first */
        $first = $result[0];

        $this->assertEquals(BigInteger::of(15509346), $first->blockNumber);
        $this->assertEquals(CarbonImmutable::parse('2022-09-10 14:43:11.000000'), $first->timeStamp);
        $this->assertEquals(BigInteger::of('2000000000000000'), $first->value);
        $this->assertEquals(false, $first->isError);
        $this->assertEquals('0_1', $first->traceId);
    }

    public function testGetERC20TransfersByAddress()
    {
        // given
        $mockedResponse = file_get_contents(__DIR__.'/../Mocks/getERC20TransfersByAddress.json');
        $handler = $this->mockJsonResponse($mockedResponse);
        $client = $this->clientWithHandler($handler);
        $etherscan = new Etherscan(Chain::Ethereum, 'secret', $client);

        // when
        $result = $etherscan->accounts()->getERC20TransfersByAddress(
            address: '0x648aA14e4424e0825A5cE739C8C68610e143FB79',
            startBlock: 15500000,
            endBlock: 16600000,
        );

        // then
        /** @var ERC20Transfer $first */
        $first = $result[0];

        $this->assertEquals(BigInteger::of(15501106), $first->blockNumber);
        $this->assertEquals(BigInteger::of('1000000'), $first->value);
        $this->assertEquals('USD Coin', $first->tokenName);
        $this->assertEquals(6, $first->tokenDecimal);
    }

    public function testGetERC721TransfersByAddress()
    {
        // given
        $mockedResponse = file_get_contents(__DIR__.'/../Mocks/getERC721TransfersByAddress.json');
        $handler = $this->mockJsonResponse($mockedResponse);
        $client = $this->clientWithHandler($handler);
        $etherscan = new Etherscan(Chain::Ethereum, 'secret', $client);

        // when
        $result = $etherscan->accounts()->getERC721TransfersByAddress(
            address: '0x648aA14e4424e0825A5cE739C8C68610e143FB79',
            startBlock: 15500000,
            endBlock: 16600000,
        );

        // then
        /** @var ERC721Transfer $first */
        $first = $result[0];

        $this->assertEquals(BigInteger::of(15521222), $first->blockNumber);
        $this->assertEquals('1', $first->tokenId);
        $this->assertEquals('gm pepe', $first->tokenName);
        $this->assertEquals(0, $first->tokenDecimal);
    }

    public function testGetERC1155TransfersByAddress()
    {
        // given
        $mockedResponse = file_get_contents(__DIR__.'/../Mocks/getERC1155TransfersByAddress.json');
        $handler = $this->mockJsonResponse($mockedResponse);
        $client = $this->clientWithHandler($handler);
        $etherscan = new Etherscan(Chain::Ethereum, ''); //, 'secret', $client);

        // when
        $result = $etherscan->accounts()->getERC1155TransfersByAddress(
            address: '0x648aA14e4424e0825A5cE739C8C68610e143FB79',
            startBlock: 15500000,
            endBlock: 16600000,
        );

        // then
        /** @var ERC1155Transfer $first */
        $first = $result[1];

        $this->assertEquals(BigInteger::of(15544413), $first->blockNumber);
        $this->assertEquals('1', $first->tokenId);
        $this->assertEquals('Anime AMATO Collection', $first->tokenName);
        $this->assertEquals(1, $first->tokenValue);
    }
}
