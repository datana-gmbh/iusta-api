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
use Datana\Iusta\Api\Domain\Value\DatasetTypeId;
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

    public function create(string $name, DatasetTypeId $datasetTypeId, array $customFieldValues = []): CreatedDataset
    {
        TrimmedNonEmptyString::fromString($name);

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
}
