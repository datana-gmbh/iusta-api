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

namespace Datana\Iusta\Api\Domain\Enum;

use OskarStark\Enum\Trait\Comparable;
use OskarStark\Enum\Trait\ToArray;

enum InboxDocumentTaskStatus: int
{
    use Comparable;
    use ToArray;
    case Distribution = 0;
    case Finished = 1;
    case Deadlines = 2;
    case Approval = 3;
    case Clickwork = 4;
    case Add = 5;
}
