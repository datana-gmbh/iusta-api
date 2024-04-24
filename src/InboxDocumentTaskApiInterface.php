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

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface InboxDocumentTaskApiInterface
{
    public function createByDocumentId(DocumentId $documentId, ?\DateTimeInterface $arrivedAt = null, ?InboxDocumentTaskStatus $inboxDocumentTaskStatus = InboxDocumentTaskStatus::Add): InboxDocumentTask;
}
