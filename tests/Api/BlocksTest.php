<?php

namespace Nemo\Etherscan\Tests\Api;

use Brick\Math\BigDecimal;
use Carbon\CarbonImmutable;
use Nemo\Etherscan\Etherscan;
use Nemo\Etherscan\Support\Chain;
use Nemo\Etherscan\Tests\TestCase;

class BlocksTest extends TestCase
{
    public function testGetBlockRewardsByNumber()
    {
        // given
        $mockedResponse = file_get_contents(__DIR__.'/../Mocks/getBlockRewardsByNumber.json');
        $handler = $this->mockJsonResponse($mockedResponse);
        $client = $this->clientWithHandler($handler);
        $etherscan = new Etherscan(Chain::Ethereum, 'secret', $client);

        // when
        $result = $etherscan->blocks()->getBlockRewardsByNumber(BigDecimal::of(2165403));

        // then
        $this->assertEquals(BigDecimal::of(2165403), $result->blockNumber);
        $this->assertEquals(CarbonImmutable::parse('2016-08-30 05:12:59.000000'), $result->timeStamp);
        $this->assertEquals('0x13a06d3dfe21e0db5c016c03ea7d2509f7f8d1e3', $result->blockMiner);
        $this->assertEquals(BigDecimal::of('5314181600000000000'), $result->blockReward);
        $this->assertEquals(BigDecimal::of('312500000000000000'), $result->uncleInclusionReward);
    }
}
