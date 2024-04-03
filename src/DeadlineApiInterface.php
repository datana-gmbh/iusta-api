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
use Datana\Iusta\Api\Domain\Value\User;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface DeadlineApiInterface
{
    public function create(CaseId $caseId, \DateTimeImmutable $dueAt, ?User $user = null, ?DeadlineTypeId $deadlineTypeId = null, Status $status = Status::Open, ?\DateTimeImmutable $preDueAt = null, ?DeadlineName $name = null, ?string $comment = null): Deadline;
}
