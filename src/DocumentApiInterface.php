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
use Datana\Iusta\Api\Domain\Value\Document\FileName;
use Datana\Iusta\Api\Domain\Value\Document\Migration\OldDocumentId;
use Datana\Iusta\Api\Domain\Value\Document\MimeType;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface DocumentApiInterface
{
    public function update(DocumentId $id, ?FileName $fileName = null, ?MimeType $mimeType = null, ?\DateTimeInterface $timestamp = null, ?OldDocumentId $oldDocumentId = null): Document;

    public function upload(string $filepath): Document;
}
