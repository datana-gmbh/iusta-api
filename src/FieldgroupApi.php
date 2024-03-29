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

use Datana\Iusta\Api\Domain\Value\CaseGroup\CaseGroupId;
use Datana\Iusta\Api\Domain\Value\Fieldgroup\Fieldgroup;
use Datana\Iusta\Api\Domain\Value\Fieldgroup\FieldgroupId;
use Datana\Iusta\Api\Domain\Value\Fieldgroup\FieldgroupName;
use Datana\Iusta\Api\Exception\FieldgroupNotFoundException;
use Datana\Iusta\Api\Exception\MoreThanOneFieldgroupFoundException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class FieldgroupApi implements FieldgroupApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function create(FieldgroupName $name, ?int $sort = null, ?CaseGroupId $caseGroupId = null): Fieldgroup
    {
        $endpoint = '/api/CustomFieldGroups';

        if ($caseGroupId instanceof CaseGroupId) {
            $endpoint = sprintf('/api/CaseGroups/%d/CustomFieldGroups', $caseGroupId->toInt());
        }

        $response = $this->client->request(
            'POST',
            $endpoint,
            [
                'json' => [
                    'name' => $name->toString(),
                    'sort' => $sort,
                ],
            ],
        );

        return new Fieldgroup($response->toArray());
    }

    public function getAll(): array
    {
        $response = $this->client->request(
            'GET',
            '/api/CustomFieldGroups',
        );

        return \array_map(
            static fn (array $values) => new Fieldgroup($values),
            $response->toArray(),
        );
    }

    public function getByName(FieldgroupName $name): Fieldgroup
    {
        $response = $this->client->request(
            'GET',
            '/api/CustomFieldGroups',
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
            throw FieldgroupNotFoundException::forName($name);
        }

        if (\count($array) > 1) {
            throw MoreThanOneFieldgroupFoundException::forName($name);
        }

        return new Fieldgroup($array[0]);
    }

    public function addCaseGroup(FieldgroupId $fieldgroupId, CaseGroupId $caseGroupId): Fieldgroup
    {
        $response = $this->client->request(
            'POST',
            sprintf('/api/CustomFieldGroups/%d/addCaseGroup/%d', $fieldgroupId->toInt(), $caseGroupId->toInt()),
        );

        return new Fieldgroup($response->toArray());
    }

    public function removeCaseGroup(FieldgroupId $fieldgroupId, CaseGroupId $caseGroupId): ResponseInterface
    {
        return $this->client->request(
            'DELETE',
            sprintf('/api/CustomFieldGroups/%d/removeCaseGroup/%d', $fieldgroupId->toInt(), $caseGroupId->toInt()),
        );
    }
}
