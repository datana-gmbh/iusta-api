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

namespace Datana\Iusta\Api\Tests\Unit\Domain\Value\CaseGroup;

use Datana\Iusta\Api\Domain\Value\CaseGroup\CaseGroupId;
use Ergebnis\Test\Util\Helper;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Datana\Iusta\Api\Domain\Value\CaseGroup\CaseGroupId
 */
final class CaseGroupIdTest extends TestCase
{
    use Helper;

    /**
     * @test
     *
     * @dataProvider \Ergebnis\Test\Util\DataProvider\IntProvider::greaterThanZero()
     */
    public function canBeConstructed(int $value): void
    {
        $id = new CaseGroupId($value);

        self::assertSame($value, $id->value);
        self::assertSame($value, $id->toInt());
    }

    /**
     * @test
     *
     * @dataProvider \Ergebnis\Test\Util\DataProvider\IntProvider::lessThanZero()
     * @dataProvider \Ergebnis\Test\Util\DataProvider\IntProvider::zero()
     */
    public function throwsException(int $value): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new CaseGroupId($value);
    }
}
