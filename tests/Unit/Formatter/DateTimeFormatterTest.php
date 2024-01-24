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

namespace Datana\Iusta\Api\Tests\Unit\Formatter;

use Datana\Iusta\Api\Formatter\DateTimeFormatter;
use Ergebnis\Test\Util\Helper;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Datana\Iusta\Api\Formatter\DateTimeFormatter
 */
final class DateTimeFormatterTest extends TestCase
{
    use Helper;

    /**
     * @test
     */
    public function format(): void
    {
        self::assertSame(
            '2024-11-12T11:23:59+00:00',
            (new DateTimeFormatter())->format(new \DateTimeImmutable('2024-11-12 11:23:59')),
        );
    }
}
