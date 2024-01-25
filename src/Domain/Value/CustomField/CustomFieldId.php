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

namespace Datana\Iusta\Api\Domain\Value\CustomField;

use Datana\Iusta\Api\Domain\Value\Base\AbstractId;

final class CustomFieldId extends AbstractId
{
    public static function fromString(string $value): self
    {
        return new self((int) str_replace('cf_', '', $value));
    }

    public function toString(): string
    {
        return 'cf_'.$this->value;
    }
}
