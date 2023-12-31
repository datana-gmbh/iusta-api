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
use Datana\Iusta\Api\Domain\Value\CustomFieldId;
use Datana\Iusta\Api\Domain\Value\DatasetId;
use Datana\Iusta\Api\Domain\Value\DocumentCategoryId;
use Datana\Iusta\Api\Domain\Value\DocumentId;
use Datana\Iusta\Api\Exception\MoreThanOneDocumentCreatedException;
use Datana\Iusta\Api\Exception\NoDocumentsCreatedException;
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
        private ImportApiInterface $importApi,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function getById(CaseId $id): ResponseInterface
    {
        return $this->client->request(
            'GET',
            sprintf('/api/Cases/%s', $id->value),
        );
    }

    public function getAll(): ResponseInterface
    {
        return $this->client->request(
            'GET',
            '/api/Cases',
        );
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

        return $this->client->request(
            'POST',
            sprintf('/api/Cases/%d/Permissions', $id->value),
            [
                'json' => $payload,
            ],
        );
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

        return $this->client->request(
            'POST',
            '/api/Comments',
            [
                'json' => $payload,
            ],
        );
    }

    public function addDocument(CaseId $id, string $filepath, ?DocumentCategoryId $documentCategoryId = null): CreatedDocument
    {
        Assert::fileExists($filepath);

        if (null === $documentCategoryId) {
            $documentCategoryId = new DocumentCategoryId(0);
        }

        $response = $this->client->request(
            'POST',
            sprintf('/api/Imports/v2/updateCase/%s/createDocumentsFromFile', $id->toInt()),
            [
                'query' => [
                    'documentCategoryId' => $documentCategoryId->toInt(),
                ],
                'body' => [
                    'file' => fopen($filepath, 'rb'),
                ],
            ],
        );

        $createdDocuments = new CreatedDocuments($response->toArray());

        $count = \count($createdDocuments->documents);

        if (0 === $count) {
            throw new NoDocumentsCreatedException();
        }

        if (1 < $count) {
            throw new MoreThanOneDocumentCreatedException();
        }

        return $createdDocuments->documents[0];
    }

    public function connectDocument(CaseId $id, DocumentId $documentId, CustomFieldId $customFieldId): ResponseInterface
    {
        $this->logger->debug('Connect Document to Case via CustomFieldValue', [
            'caseId' => $id->toInt(),
            'documentId' => $documentId->toInt(),
            'customFieldId' => $customFieldId->toInt(),
        ]);

        return $this->importApi->updateCase(
            id: $id,
            customFieldvalues: [
                [
                    'id' => $customFieldId->toInt(),
                    'value' => $documentId->toInt(),
                ],
            ],
        );
    }

    public function connectDataset(CaseId $id, DatasetId $datasetId, CustomFieldId $customFieldId): ResponseInterface
    {
        $this->logger->debug('Connect Dataset to Case via CustomFieldValue', [
            'caseId' => $id->toInt(),
            'datasetId' => $datasetId->toInt(),
            'customFieldId' => $customFieldId->toInt(),
        ]);

        return $this->importApi->updateCase(
            id: $id,
            customFieldvalues: [
                [
                    'id' => $customFieldId->toInt(),
                    'value' => $datasetId->toInt(),
                ],
            ],
        );
    }
}
