<?php

declare(strict_types=1);

namespace Nemo\Etherscan\Api;

use Brick\Math\BigInteger;
use Brick\Math\Exception\MathException;
use GuzzleHttp\Exception\GuzzleException;
use Nemo\Etherscan\Exceptions\ApiException;
use Nemo\Etherscan\Exceptions\IllegalParameterException;
use Nemo\Etherscan\Exceptions\TransformResponseException;
use Nemo\Etherscan\ValueObjects\ERC1155Transfer;
use Nemo\Etherscan\ValueObjects\ERC20Transfer;
use Nemo\Etherscan\ValueObjects\ERC721Transfer;
use Nemo\Etherscan\ValueObjects\EtherBalance;
use Nemo\Etherscan\ValueObjects\InternalTransaction;
use Nemo\Etherscan\ValueObjects\NormalTransaction;

class Accounts extends Api
{
    private const MODULE = 'account';

    /**
     * Returns the Ether balance of a given address.
     *
     * @param  string  $address representing the address to check for balance
     * @param  string  $tag the pre-defined block parameter, either earliest, pending or latest
     *
     * @throws ApiException|GuzzleException|MathException|TransformResponseException
     */
    public function getEtherBalanceForAddress(string $address, string $tag = 'latest'): BigInteger
    {
        $params['action'] = 'balance';
        $params['address'] = $address;
        $params['tag'] = $tag;
        $res = $this->get(self::MODULE, $params);

        if ($res['status'] != '1') {
            throw new ApiException($res['message']);
        }

        return BigInteger::of($res['message']);
    }

    /**
     * Returns the balance of the accounts from a list of addresses.
     *
     * @param  array  $addresses representing the addresses to check
     * @param  string  $tag the pre-defined block parameter, either earliest, pending or latest
     *
     * @throws GuzzleException
     * @throws IllegalParameterException
     * @throws TransformResponseException
     * @throws MathException
     * @throws ApiException
     */
    public function getEtherBalanceForAddresses(array $addresses, string $tag = 'latest'): array
    {
        if (count($addresses) < 1 || count($addresses) > 20) {
            throw new IllegalParameterException('The addresses parameter should contain 1 to 20 addresses.');
        }

        $params['action'] = 'balancemulti';
        $params['address'] = implode(',', $addresses);
        $params['tag'] = $tag;
        $res = $this->get(self::MODULE, $params);

        if ($res['status'] != '1') {
            throw new ApiException($res['message']);
        }

        return array_map(fn ($i) => EtherBalance::fromResponse($i), $res['result']);
    }

    /**
     * Returns the list of transactions performed by an address, with optional pagination.
     *
     * @param  string  $address representing the addresses to check for transactions
     * @param  int  $startBlock block number to start searching for transactions
     * @param  int  $endBlock block number to stop searching for transactions
     * @param  int  $page number, if pagination is enabled
     * @param  int  $offset the number of transactions displayed per page
     * @param  string  $sort the sorting preference, use asc to sort by ascending and desc to sort by descending
     *
     * @throws ApiException|GuzzleException|MathException|TransformResponseException
     */
    public function getNormalTransactionsByAddress(
        string $address,
        int $startBlock = 0,
        int $endBlock = 99999999,
        int $page = 1,
        int $offset = 20,
        string $sort = 'asc'
    ): array {
        $params['action'] = 'txlist';
        $params['address'] = $address;
        $params['startblock'] = $startBlock;
        $params['endblock'] = $endBlock;
        $params['page'] = $page;
        $params['offset'] = $offset;
        $params['sort'] = $sort;
        $res = $this->get(self::MODULE, $params);

        if ($res['status'] != '1') {
            throw new ApiException($res['message']);
        }

        return array_map(fn ($i) => NormalTransaction::fromResponse($i), $res['result']);
    }

    /**
     * Returns the list of internal transactions performed by an address, with optional pagination.
     *
     * @param  string  $address representing the addresses to check for transactions
     * @param  int  $startBlock block number to start searching for transactions
     * @param  int  $endBlock block number to stop searching for transactions
     * @param  int  $page number, if pagination is enabled
     * @param  int  $offset the number of transactions displayed per page
     * @param  string  $sort the sorting preference, use asc to sort by ascending and desc to sort by descending
     *
     * @throws ApiException|GuzzleException|MathException|TransformResponseException
     */
    public function getInternalTransactionsByAddress(
        string $address,
        int $startBlock = 0,
        int $endBlock = 99999999,
        int $page = 1,
        int $offset = 20,
        string $sort = 'asc'
    ): array {
        $params['action'] = 'txlistinternal';
        $params['address'] = $address;
        $params['startblock'] = $startBlock;
        $params['endblock'] = $endBlock;
        $params['page'] = $page;
        $params['offset'] = $offset;
        $params['sort'] = $sort;
        $res = $this->get(self::MODULE, $params);

        if ($res['status'] != '1') {
            throw new ApiException($res['message']);
        }

        return array_map(fn ($i) => InternalTransaction::fromResponse($i), $res['result']);
    }

    /**
     * Returns the list of internal transactions performed within a transaction.
     *
     * @param  string  $hash representing the transaction hash to check for internal transactions
     *
     * @throws ApiException|GuzzleException|MathException|TransformResponseException
     */
    public function getInternalTransactionsByHash(string $hash): array
    {
        $params['action'] = 'txlistinternal';
        $params['txhash'] = $hash;
        $res = $this->get(self::MODULE, $params);

        if ($res['status'] != '1') {
            throw new ApiException($res['message']);
        }

        return array_map(fn ($i) => InternalTransaction::fromResponse($i), $res['result']);
    }

    /**
     * Returns the list of internal transactions performed within a block range, with optional pagination.
     *
     * @param  int  $startBlock block number to start searching for transactions
     * @param  int  $endBlock block number to stop searching for transactions
     * @param  int  $page number, if pagination is enabled
     * @param  int  $offset the number of transactions displayed per page
     * @param  string  $sort the sorting preference, use asc to sort by ascending and desc to sort by descending
     *
     * @throws ApiException|GuzzleException|MathException|TransformResponseException
     */
    public function getInternalTransactionsByBlockRange(
        int $startBlock = 0,
        int $endBlock = 99999999,
        int $page = 1,
        int $offset = 20,
        string $sort = 'asc'
    ): array {
        $params['action'] = 'txlistinternal';
        $params['startblock'] = $startBlock;
        $params['endblock'] = $endBlock;
        $params['page'] = $page;
        $params['offset'] = $offset;
        $params['sort'] = $sort;
        $res = $this->get(self::MODULE, $params);

        if ($res['status'] != '1') {
            throw new ApiException($res['message']);
        }

        return array_map(fn ($i) => InternalTransaction::fromResponse($i), $res['result']);
    }

    /**
     * @throws ApiException|GuzzleException|MathException|TransformResponseException
     */
    public function getERC20TransfersByAddress(
        ?string $address,
        ?string $contractAddress,
        int $startBlock = 0,
        int $endBlock = 99999999,
        int $page = 1,
        int $offset = 20,
        string $sort = 'asc'
    ): array {
        $params['action'] = 'tokentx';
        if (! is_null($address)) {
            $params['address'] = $address;
        }
        if (! is_null($contractAddress)) {
            $params['contractAddress'] = $contractAddress;
        }
        $params['startblock'] = $startBlock;
        $params['endblock'] = $endBlock;
        $params['page'] = $page;
        $params['offset'] = $offset;
        $params['sort'] = $sort;
        $res = $this->get(self::MODULE, $params);

        if ($res['status'] != '1') {
            throw new ApiException($res['message']);
        }

        return array_map(fn ($i) => ERC20Transfer::fromResponse($i), $res['result']);
    }

    /**
     * @throws ApiException|GuzzleException|MathException|TransformResponseException
     */
    public function getERC721TransfersByAddress(
        ?string $address,
        ?string $contractAddress,
        int $startBlock = 0,
        int $endBlock = 99999999,
        int $page = 1,
        int $offset = 20,
        string $sort = 'asc'
    ): array {
        $params['action'] = 'tokennfttx';
        if (! is_null($address)) {
            $params['address'] = $address;
        }
        if (! is_null($contractAddress)) {
            $params['contractAddress'] = $contractAddress;
        }
        $params['startblock'] = $startBlock;
        $params['endblock'] = $endBlock;
        $params['page'] = $page;
        $params['offset'] = $offset;
        $params['sort'] = $sort;
        $res = $this->get(self::MODULE, $params);

        if ($res['status'] != '1') {
            throw new ApiException($res['message']);
        }

        return array_map(fn ($i) => ERC721Transfer::fromResponse($i), $res['result']);
    }

    /**
     * @throws ApiException|GuzzleException|MathException|TransformResponseException
     */
    public function getERC1155TransfersByAddress(
        ?string $address,
        ?string $contractAddress,
        int $startBlock = 0,
        int $endBlock = 99999999,
        int $page = 1,
        int $offset = 20,
        string $sort = 'asc'
    ): array {
        $params['action'] = 'token1155tx';
        if (! is_null($address)) {
            $params['address'] = $address;
        }
        if (! is_null($contractAddress)) {
            $params['contractAddress'] = $contractAddress;
        }
        $params['startblock'] = $startBlock;
        $params['endblock'] = $endBlock;
        $params['page'] = $page;
        $params['offset'] = $offset;
        $params['sort'] = $sort;
        $res = $this->get(self::MODULE, $params);

        if ($res['status'] != '1') {
            throw new ApiException($res['message']);
        }

        return array_map(fn ($i) => ERC1155Transfer::fromResponse($i), $res['result']);
    }
}
