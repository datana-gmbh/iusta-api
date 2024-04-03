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
use Datana\Iusta\Api\Domain\Value\Deadline\Deadline;
use Datana\Iusta\Api\Domain\Value\Deadline\DeadlineName;
use Datana\Iusta\Api\Domain\Value\Deadline\Status;
use Datana\Iusta\Api\Domain\Value\DeadlineType\DeadlineTypeId;
use Datana\Iusta\Api\Formatter\DateTimeFormatterInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class DeadlineApi implements DeadlineApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        private DateTimeFormatterInterface $dateTimeFormatter,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function create(CaseId $caseId, \DateTimeInterface $dueAt, ?DeadlineTypeId $deadlineTypeId = null, Status $status = Status::Open, ?\DateTimeInterface $preDueAt = null, ?DeadlineName $name = null, ?string $comment = null): Deadline
    {
        $response = $this->client->request(
            'POST',
            '/api/Deadlines',
            [
                'json' => [
                    'caseId' => $caseId->toInt(),
                    'dueAt' => $this->dateTimeFormatter->format($dueAt),
                    'preDueAt' => $preDueAt instanceof \DateTimeInterface ? $this->dateTimeFormatter->format($preDueAt) : null,
                    'name' => $name?->toString(),
                    'comment' => $comment,
                    'deadlineTypeId' => $deadlineTypeId?->toInt(),
                    'status' => $status->value,
                ],
            ],
        );

        return new Deadline($response->toArray());
    }
}
