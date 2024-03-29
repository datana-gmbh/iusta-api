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

use Datana\Iusta\Api\Domain\Value\CaseGroup\CaseGroup;
use Datana\Iusta\Api\Domain\Value\CaseGroup\CaseGroupId;
use Datana\Iusta\Api\Domain\Value\CaseGroup\CaseGroupName;
use Datana\Iusta\Api\Domain\Value\Fieldgroup\FieldgroupId;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface CaseGroupApiInterface
{
    public function getById(CaseGroupId $id): CaseGroup;

    public function getByName(CaseGroupName $name): CaseGroup;

    /**
     * @return list<CaseGroup>
     */
    public function byFieldgroupId(FieldgroupId $fieldgroupId): array;
}
