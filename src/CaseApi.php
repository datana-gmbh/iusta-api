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

use Datana\Iusta\Api\Domain\Value\CaseId;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;
use function Safe\sprintf;

final class CaseApi implements CaseApiInterface
{
    private IustaClient $client;
    private LoggerInterface $logger;

    public function __construct(IustaClient $client, ?LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->logger = $logger ?? new NullLogger();
    }

    public function getById(CaseId $id): ResponseInterface
    {
        try {
            $response = $this->client->request(
                'GET',
                sprintf('/api/Cases/%s', $id->value),
            );

            $this->logger->debug('Response', $response->toArray(false));

            return $response;
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }

    public function getAll(): ResponseInterface
    {
        try {
            $response = $this->client->request(
                'GET',
                '/api/Cases',
            );

            $this->logger->debug('Response', $response->toArray(false));

            return $response;
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }

    public function setUserGroups(CaseId $id, array $groups): ResponseInterface
    {
        Assert::allInteger($groups);

        $payload = [];

        foreach ($groups as $group) {
            $payload[] = [
                'referenceType' => 'XUserGroup',
                'referenceId' => $group,
            ];
        }

        try {
            $response = $this->client->request(
                'POST',
                sprintf('/api/Cases/%d/Permissions', $id->value),
                [
                    'json' => $payload,
                ],
            );

            $this->logger->debug('Response', $response->toArray(false));

            return $response;
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }
}
