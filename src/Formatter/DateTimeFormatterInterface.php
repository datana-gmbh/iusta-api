<?php

declare(strict_types=1);

namespace Datana\Iusta\Api\Formatter;

interface DateTimeFormatterInterface
{
    public function format(\DateTimeInterface $dateTime): string;
}
