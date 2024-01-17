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

use OskarStark\Enum\Trait\Comparable;

enum Type: int
{
    use Comparable;
    case Unknown = 0;
    case Text = 1;
    case Textarea = 2;
    case Select = 3;
    case MultiSelect = 4;
    case Boolean = 5;
    case Date = 6;

    // case DateTime = 7;
    // case Time = 8;
    case Dataset = 9;
    case Document = 10;
    case Price = 11;
    case MultiDocument = 12;
    case MultiDataset = 13;
    case CustomFieldPointer = 14;
    case Number = 15;
    case XUser = 16;
    case Readonly = 17;
    case Html = 18;
    case CustomerFieldPointer = 19;
    case Email = 20;
    case PhoneNumber = 21;

    public function getId(): int
    {
        return $this->value;
    }

    public function isSelect(): bool
    {
        return $this->equalsOneOf([
            self::Select,
            self::MultiSelect,
        ]);
    }
}
