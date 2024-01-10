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

use Datana\Iusta\Api\Domain\Value\CreatedDataset;
use Datana\Iusta\Api\Domain\Value\Dataset\Dataset;
use Datana\Iusta\Api\Domain\Value\Dataset\DatasetName;
use Datana\Iusta\Api\Domain\Value\DatasetTypeId;
use Datana\Iusta\Api\Exception\DatasetNotFoundException;
use Datana\Iusta\Api\Exception\MoreThanOneDatasetFoundException;
use OskarStark\Value\TrimmedNonEmptyString;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class DatasetApi implements DatasetApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function create(DatasetName|string $name, DatasetTypeId $datasetTypeId, array $customFieldValues = []): CreatedDataset
    {
        if ($name instanceof DatasetName) {
            $name = $name->toString();
        } else {
            TrimmedNonEmptyString::fromString($name);
        }

        $payload = [
            'dataset' => [
                'name' => $name,
                'datasetTypeId' => $datasetTypeId->toInt(),
            ],
        ];

        if ([] !== $customFieldValues) {
            $payload['customFieldValues'] = $customFieldValues;
        }

        $response = $this->client->request(
            'POST',
            '/api/Imports/v2/newDataset',
            [
                'json' => $payload,
            ],
        );

        return new CreatedDataset($response->toArray());
    }

    public function get(DatasetName $name, DatasetTypeId $datasetTypeId): Dataset
    {
        $response = $this->client->request(
            'GET',
            '/api/Datasets',
            [
                'query' => [
                    'filter' => \Safe\json_encode([
                        'where' => [
                            'name' => $name,
                            'datasetTypeId' => $datasetTypeId->toInt(),
                        ],
                    ]),
                ],
            ],
        );

        $array = $response->toArray();

        if (!\array_key_exists(0, $array)) {
            throw DatasetNotFoundException::forNameAndDatasetTypeId($name, $datasetTypeId);
        }

        if (\count($array) > 1) {
            throw MoreThanOneDatasetFoundException::forNameAndDatasetTypeId($name, $datasetTypeId);
        }

        return new Dataset($array[0]);
    }
}
