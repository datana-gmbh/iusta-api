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

namespace Datana\Iusta\Api\Exception;

use Datana\Iusta\Api\Domain\Value\Dataset\DatasetName;
use Datana\Iusta\Api\Domain\Value\DatasetTypeId;

/**
 * @author Oskar Stark <oskarstark@googlemail.com>
 */
final class MoreThanOneDatasetFoundException extends \RuntimeException
{
    public static function forNameAndDatasetTypeId(DatasetName $name, DatasetTypeId $datasetTypeId): self
    {
        return new self(sprintf(
            'More than one dataset with name "%s" and dataset type id "%s" found.',
            $name->toString(),
            $datasetTypeId->toInt(),
        ));
    }
}
