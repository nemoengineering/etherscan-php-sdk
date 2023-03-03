<?php

declare(strict_types=1);

namespace Nemo\Etherscan\Api;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use GuzzleHttp\Exception\GuzzleException;
use Nemo\Etherscan\Exceptions\ApiException;
use Nemo\Etherscan\Exceptions\TransformResponseException;
use Nemo\Etherscan\ValueObjects\BlockRewards;

class Blocks extends Api
{
    private const MODULE = 'block';

    /**
     * Get block and uncle rewards by block number.
     *
     * @param  BigDecimal  $blockNumber the integer block number to check block rewards
     *
     * @throws ApiException|GuzzleException|MathException|TransformResponseException
     */
    public function getBlockRewardsByNumber(BigDecimal $blockNumber): BlockRewards
    {
        $params['action'] = 'getblockreward';
        $params['blockno'] = $blockNumber;
        $res = $this->get(self::MODULE, $params);

        if ($res['status'] != '1') {
            throw new ApiException("{$res['message']}\nURI: {$this->client->getHttpClient()->getConfig('base_uri')}\nAction: {$params['action']}");
        }

        return BlockRewards::fromResponse($res['result']);
    }
}
