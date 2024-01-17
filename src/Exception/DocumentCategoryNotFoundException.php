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

use Datana\Iusta\Api\Domain\Value\DocumentCategory\DocumentCategoryName;

/**
 * @author Oskar Stark <oskarstark@googlemail.com>
 */
final class DocumentCategoryNotFoundException extends \RuntimeException
{
    public static function forName(DocumentCategoryName $name): self
    {
        return new self(sprintf(
            'DocumentCategory with name "%s" not found.',
            $name->toString(),
        ));
    }
}
