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

namespace Datana\Iusta\Api\Domain\Value\Base;

use OskarStark\Value\TrimmedNonEmptyString;

abstract class AbstractString
{
    public function __construct(
        protected string $value,
    ) {
        TrimmedNonEmptyString::fromString($value);
    }

    final public function toString(): string
    {
        return $this->value;
    }
}
