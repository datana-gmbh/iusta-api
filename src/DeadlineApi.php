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
use Datana\Iusta\Api\Domain\Value\DeadlineType\DeadlineType;
use Datana\Iusta\Api\Domain\Value\DeadlineType\DeadlineTypeName;
use Datana\Iusta\Api\Exception\DeadlineTypeNotFoundException;
use Datana\Iusta\Api\Exception\MoreThanOneDeadlineTypeFoundException;
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

    public function create(CaseId $caseId, \DateTimeImmutable $dueAt, DeadlineType $deadlineType, Status $status = Status::Open, ?\DateTimeImmutable $preDueAt = null, ?DeadlineName $name = null, ?string $comment = null): Deadline
    {
        $response = $this->client->request(
            'POST',
            '/api/Deadlines',
            [
                'json' => array_filter([
                    'caseId' => $caseId->toInt(),
                    'dueAt' => $this->dateTimeFormatter->format($dueAt),
                    'preDueAt' => $this->dateTimeFormatter->format($preDueAt),
                    'name' => $name->toString(),
                    'comment' => $comment,
                    'deadlineTypeId' => $deadlineType->id->toInt(),
                ]),
            ],
        );

        return new Deadline($response->toArray());
    }
}
