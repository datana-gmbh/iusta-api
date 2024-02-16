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

namespace Datana\Iusta\Api\Exception;

use Datana\Iusta\Api\Domain\Value\InboxDocument\InboxDocumentCategoryId;

/**
 * @author Oskar Stark <oskarstark@googlemail.com>
 */
final class MoreThanOneInboxDocumentFoundException extends \RuntimeException
{
    public static function forFilepathAndCategoryId(string $filepath, InboxDocumentCategoryId $categoryId): self
    {
        return new self(sprintf(
            'More than one InboxDocument found for filepath "%s" and categoryId "%s"',
            $filepath,
            $categoryId->toInt(),
        ));
    }
}
