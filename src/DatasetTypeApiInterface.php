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

use Datana\Iusta\Api\Domain\Value\DatasetType\DatasetType;
use Datana\Iusta\Api\Domain\Value\DatasetType\DatasetTypeName;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface DatasetTypeApiInterface
{
    public function create(DatasetTypeName $name): DatasetType;

    public function get(DatasetTypeName $name): DatasetType;
}