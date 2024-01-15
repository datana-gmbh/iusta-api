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

use Datana\Iusta\Api\Domain\Value\Dataset\FieldgroupName;

/**
 * @author Oskar Stark <oskarstark@googlemail.com>
 */
final class MoreThanOneFieldgroupFoundException extends \RuntimeException
{
    public static function forName(FieldgroupName $name): self
    {
        return new self(sprintf(
            'More than one Fieldgroup with name "%s" found.',
            $name->toString(),
        ));
    }
}
