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
use Datana\Iusta\Api\Domain\Value\CreatedDocument;
use Datana\Iusta\Api\Domain\Value\CreatedDocuments;
use OskarStark\Value\TrimmedNonEmptyString;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;
use function Safe\fopen;

final class CaseApi implements CaseApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        ?LoggerInterface $logger = null,
    ) {
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

    /**
     * @param array<mixed> $payload
     */
    public function addComment(CaseId $id, array $payload): ResponseInterface
    {
        Assert::notEmpty($payload);
        Assert::keyExists($payload, 'msg');
        TrimmedNonEmptyString::fromString($payload['msg']);

        $payload['referenceId'] = $id->value;
        $payload['referenceType'] = 'Case';

        try {
            $response = $this->client->request(
                'POST',
                '/api/Comments',
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

    public function addDocument(CaseId $id, string $filepath, int $documentCategory = 0): CreatedDocument
    {
        Assert::fileExists($filepath);

        try {
            $response = $this->client->request(
                'POST',
                sprintf('/api/Imports/v2/updateCase/%s/createDocumentsFromFile', $id->toInt()),
                [
                    'query' => [
                        'documentCategoryId' => $documentCategory,
                    ],
                    'body' => [
                        'file' => fopen($filepath, 'rb'),
                    ],
                ],
            );

            $this->logger->debug('Response', $response->toArray(false));

            $createdDocuments = new CreatedDocuments($response->toArray());

            $count = \count($createdDocuments->documents);

            if (0 === $count) {
                throw new \RuntimeException('Expected one document to be created.');
            }

            if (1 < $count) {
                throw new \RuntimeException('Expected exactly one document to be created.');
            }

            return $createdDocuments->documents[0];
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }
}
