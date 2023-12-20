<?php

declare(strict_types=1);

namespace Datana\Iusta\Api\Domain\Value;

use Webmozart\Assert\Assert;

final readonly class CaseId
{
    public function __construct(
        public int $value,
    ) {
        Assert::greaterThan($value, 0);
    }
}
