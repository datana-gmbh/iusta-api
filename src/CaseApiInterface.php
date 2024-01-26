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

use Datana\Iusta\Api\Domain\Value\Case\CaseId;
use Datana\Iusta\Api\Domain\Value\CustomField\CustomFieldId;
use Datana\Iusta\Api\Domain\Value\Dataset\DatasetId;
use Datana\Iusta\Api\Domain\Value\Document\Document;
use Datana\Iusta\Api\Domain\Value\Document\DocumentId;
use Datana\Iusta\Api\Domain\Value\DocumentCategory\DocumentCategoryId;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface CaseApiInterface
{
    public function getById(CaseId $id): ResponseInterface;

    public function getAll(): ResponseInterface;

    /**
     * @param array<int> $groups
     */
    public function setUserGroups(CaseId $id, array $groups): ResponseInterface;

    /**
     * @param array<mixed> $payload
     */
    public function addComment(CaseId $id, array $payload): ResponseInterface;

    public function addDocument(CaseId $id, string $filepath, ?DocumentCategoryId $documentCategoryId = null): Document;

    public function connectDocument(CaseId $id, DocumentId $documentId, CustomFieldId $customFieldId): ResponseInterface;

    public function connectDataset(CaseId $id, DatasetId $datasetId, CustomFieldId $customFieldId): ResponseInterface;
}
