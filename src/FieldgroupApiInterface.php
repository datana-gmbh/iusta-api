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

use Datana\Iusta\Api\Domain\Value\CaseGroup\CaseGroupId;
use Datana\Iusta\Api\Domain\Value\Fieldgroup\Fieldgroup;
use Datana\Iusta\Api\Domain\Value\Fieldgroup\FieldgroupName;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface FieldgroupApiInterface
{
    /**
     * @param null|CaseGroupId $caseGroupId if set, the fieldgroup will be assigned to the given CaseGroup
     */
    public function create(FieldgroupName $name, ?int $sort = null, ?CaseGroupId $caseGroupId = null): Fieldgroup;

    public function get(FieldgroupName $name): Fieldgroup;
}