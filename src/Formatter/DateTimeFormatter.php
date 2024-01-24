<?php

declare(strict_types=1);

namespace Datana\Iusta\Api\Formatter;

final readonly class DateTimeFormatter implements DateTimeFormatterInterface
{
    public function format(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format(\DateTimeInterface::ATOM);
    }
}
