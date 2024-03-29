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

use Datana\Iusta\Api\Domain\Value\CaseGroup\CaseGroup;
use Datana\Iusta\Api\Domain\Value\CaseGroup\CaseGroupId;
use Datana\Iusta\Api\Domain\Value\CaseGroup\CaseGroupName;
use Datana\Iusta\Api\Domain\Value\Fieldgroup\FieldgroupId;
use Datana\Iusta\Api\Exception\CaseGroupNotFoundException;
use Datana\Iusta\Api\Exception\MoreThanOneCaseGroupFoundException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class CaseGroupApi implements CaseGroupApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function getById(CaseGroupId $id): CaseGroup
    {
        $response = $this->client->request(
            'GET',
            sprintf('/api/CaseGroups/%s', $id->toInt()),
        );

        return new CaseGroup($response->toArray());
    }

    public function getByName(CaseGroupName $name): CaseGroup
    {
        $response = $this->client->request(
            'GET',
            '/api/CaseGroups',
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
            throw CaseGroupNotFoundException::forName($name);
        }

        if (\count($array) > 1) {
            throw MoreThanOneCaseGroupFoundException::forName($name);
        }

        return new CaseGroup($array[0]);
    }

    /**
     * @return list<CaseGroup>
     */
    public function byFieldgroupId(FieldgroupId $fieldgroupId): array
    {
        $response = $this->client->request(
            'GET',
            sprintf('/api/CustomFieldGroups/%s/CaseGroups', $fieldgroupId->toInt()),
        );

        return \array_map(
            static fn (array $values) => new CaseGroup($values),
            $response->toArray(),
        );
    }
}
