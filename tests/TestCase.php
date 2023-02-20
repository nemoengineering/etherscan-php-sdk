<?php

namespace Nemo\Etherscan\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    protected const BASE_URI = 'https://api.etherscan.io';

    protected function clientWithHandler(HandlerStack $handlerStack): Client
    {
        return new Client([
            'base_uri' => self::BASE_URI,
            'handler' => $handlerStack,
        ]);
    }

    protected function mockJsonResponse(string $json): HandlerStack
    {
        $headers = ['Content-Type' => 'application/json'];

        $response = new Response(200, $headers, $json);
        $mock = new MockHandler([$response]);

        return HandlerStack::create($mock);
    }
}
