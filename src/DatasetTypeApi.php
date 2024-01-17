<?php

declare(strict_types=1);

/**
 * This file is part of Iusta-Api.
 *
 * (c) Datana GmbH <info@datana.rocks>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Datana\Iusta\Api;

use Datana\Iusta\Api\Domain\Value\DatasetType\DatasetType;
use Datana\Iusta\Api\Domain\Value\DatasetType\DatasetTypeName;
use Datana\Iusta\Api\Exception\DatasetTypeNotFoundException;
use Datana\Iusta\Api\Exception\MoreThanOneDatasetTypeFoundException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class DatasetTypeApi implements DatasetTypeApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function create(DatasetTypeName $name): DatasetType
    {
        $response = $this->client->request(
            'POST',
            '/api/DatasetTypes',
            [
                'json' => [
                    'name' => $name->toString(),
                ],
            ],
        );

        return new DatasetType($response->toArray());
    }

    public function get(DatasetTypeName $name): DatasetType
    {
        $response = $this->client->request(
            'GET',
            '/api/DatasetTypes',
            [
                'query' => [
                    'filter' => \Safe\json_encode([
                        'where' => [
                            'name' => $name->toString(),
                        ],
                    ]),
                ],
            ],
        );

        $array = $response->toArray();

        if (!\array_key_exists(0, $array)) {
            throw DatasetTypeNotFoundException::forName($name);
        }

        if (\count($array) > 1) {
            throw MoreThanOneDatasetTypeFoundException::forName($name);
        }

        return new DatasetType($array[0]);
    }
}
