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

namespace Datana\Iusta\Api\Domain\Value\DatasetType;

use OskarStark\Value\TrimmedNonEmptyString;

final readonly class DatasetTypeName
{
    public function __construct(
        public string $value,
    ) {
        TrimmedNonEmptyString::fromString($value);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
