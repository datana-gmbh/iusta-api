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

namespace Datana\Iusta\Api\Formatter;

final readonly class DateTimeFormatter implements DateTimeFormatterInterface
{
    public function format(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format(\DateTimeInterface::ATOM);
    }
}
