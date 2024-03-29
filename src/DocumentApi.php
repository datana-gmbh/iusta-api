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

use Datana\Iusta\Api\Domain\Value\Document\Document;
use Datana\Iusta\Api\Domain\Value\Document\DocumentId;
use Datana\Iusta\Api\Domain\Value\Document\Documents;
use Datana\Iusta\Api\Domain\Value\Document\FileName;
use Datana\Iusta\Api\Domain\Value\Document\Migration\OldDocumentId;
use Datana\Iusta\Api\Domain\Value\Document\MimeType;
use Datana\Iusta\Api\Exception\MoreThanOneDocumentCreatedException;
use Datana\Iusta\Api\Exception\NoDocumentsCreatedException;
use Datana\Iusta\Api\Formatter\DateTimeFormatterInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Webmozart\Assert\Assert;
use function Safe\fopen;

final class DocumentApi implements DocumentApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        private DateTimeFormatterInterface $dateTimeFormatter,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function upload(string $filepath): Document
    {
        Assert::fileExists($filepath);

        $response = $this->client->request(
            'POST',
            '/api/Documents/0/0/createMultipleFromFile',
            [
                'body' => [
                    'file' => fopen($filepath, 'rb'),
                ],
                'timeout' => 100, // this call can take quite long...
            ],
        );

        $createdDocuments = new Documents($response->toArray());

        $count = \count($createdDocuments->documents);

        if (0 === $count) {
            throw new NoDocumentsCreatedException();
        }

        if (1 < $count) {
            throw new MoreThanOneDocumentCreatedException();
        }

        return $createdDocuments->documents[0];
    }

    public function update(DocumentId $id, ?FileName $fileName = null, ?MimeType $mimeType = null, ?\DateTimeInterface $timestamp = null, ?OldDocumentId $oldDocumentId = null): Document
    {
        $response = $this->client->request(
            'PATCH',
            sprintf('/api/Documents/%s', $id->toInt()),
            [
                'json' => array_filter([
                    'fileName' => $fileName?->toString(),
                    'fileMime' => $mimeType?->toString(),
                    'migration_oldDocumentId' => $oldDocumentId?->toInt(),
                    'timestamp' => $timestamp instanceof \DateTimeInterface
                        ? $this->dateTimeFormatter->format($timestamp)
                        : null,
                ]),
            ],
        );

        return new Document($response->toArray());
    }
}
