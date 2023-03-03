<?php

namespace Nemo\Etherscan\Tests\Api;

use Brick\Math\BigDecimal;
use Nemo\Etherscan\Etherscan;
use Nemo\Etherscan\Support\Chain;
use Nemo\Etherscan\Tests\TestCase;

class ProxyTest extends TestCase
{
    public function testGetTransactionByHash()
    {
        // given
        $mockedResponse = file_get_contents(__DIR__.'/../Mocks/getTransactionByHash.json');
        $handler = $this->mockJsonResponse($mockedResponse);
        $client = $this->clientWithHandler($handler);
        $etherscan = new Etherscan(Chain::Ethereum, 'secret', $client);

        // when
        $result = $etherscan->proxy()->getTransactionByHash('0xbc78ab8a9e9a0bca7d0321a27b2c03addeae08ba81ea98b03cd3dd237eabed44');

        // then
        $this->assertEquals(BigDecimal::of(13575200), $result->blockNumber);
        $this->assertEquals('0xf850331061196b8f2b67e1f43aaa9e69504c059d3d3fb9547b04f9ed4d141ab7', $result->blockHash);
        $this->assertEquals(1, $result->chainId);
        $this->assertEquals('0x', $result->input);
        $this->assertEquals(BigDecimal::of('7165918000000000'), $result->value);
    }
}
