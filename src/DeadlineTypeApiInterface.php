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

namespace Datana\Iusta\Api;

use Datana\Iusta\Api\Domain\Value\DeadlineType\DeadlineType;
use Datana\Iusta\Api\Domain\Value\DeadlineType\DeadlineTypeName;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface DeadlineTypeApiInterface
{
    public function create(DeadlineTypeName $name): DeadlineType;

    public function getByName(DeadlineTypeName $name): DeadlineType;
}
