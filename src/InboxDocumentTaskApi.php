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

use Datana\Iusta\Api\Domain\Enum\InboxDocumentTaskStatus;
use Datana\Iusta\Api\Domain\Value\Document\DocumentId;
use Datana\Iusta\Api\Domain\Value\InboxDocumentTask\InboxDocumentTask;
use Datana\Iusta\Api\Formatter\DateTimeFormatterInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class InboxDocumentTaskApi implements InboxDocumentTaskApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        private DateTimeFormatterInterface $dateTimeFormatter,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function createByDocumentId(DocumentId $documentId, ?\DateTimeInterface $arrivedAt = null, ?InboxDocumentTaskStatus $inboxDocumentTaskStatus = null): InboxDocumentTask
    {
        if (null === $inboxDocumentTaskStatus) {
            $inboxDocumentTaskStatus = InboxDocumentTaskStatus::Add;
        }

        $payload = [];

        if (null !== $arrivedAt) {
            $payload['arrival'] = $this->dateTimeFormatter->format($arrivedAt);
        }

        $payload['status'] = $inboxDocumentTaskStatus->value;

        $this->logger->debug('Adding DocumentInboxTask with payload', ['payload' => $payload]);

        $response = $this->client->request(
            'POST',
            sprintf('/api/Documents/%d/DocumentInboxTask', $documentId->toInt()),
            ['body' => $payload],
        );

        return new InboxDocumentTask($response->toArray());
    }
}
