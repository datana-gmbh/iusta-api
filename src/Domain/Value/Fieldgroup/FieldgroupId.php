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

namespace Datana\Iusta\Api\Domain\Value\Fieldgroup;

use Webmozart\Assert\Assert;

final readonly class FieldgroupId
{
    public function __construct(
        public int $value,
    ) {
        Assert::greaterThan($value, 0);
    }

    public function toInt(): int
    {
        return $this->value;
    }
}
