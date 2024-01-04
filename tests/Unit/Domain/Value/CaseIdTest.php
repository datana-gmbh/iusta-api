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

namespace Datana\Iusta\Api\Tests\Unit\Domain\Value;

use Datana\Iusta\Api\Domain\Value\CaseId;
use Ergebnis\Test\Util\Helper;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Datana\Iusta\Api\Domain\Value\CaseId
 */
final class CaseIdTest extends TestCase
{
    use Helper;

    /**
     * @test
     *
     * @dataProvider \Ergebnis\Test\Util\DataProvider\IntProvider::greaterThanZero()
     */
    public function fromIntGreaterThanZero(int $value): void
    {
        self::assertSame(
            $value,
            (new CaseId($value))->value,
        );
    }

    /**
     * @test
     *
     * @dataProvider \Ergebnis\Test\Util\DataProvider\IntProvider::lessThanZero()
     * @dataProvider \Ergebnis\Test\Util\DataProvider\IntProvider::zero()
     */
    public function fromIntThrowsException(int $value): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new CaseId($value);
    }
}