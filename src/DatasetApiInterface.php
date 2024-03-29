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

use Datana\Iusta\Api\Domain\Value\Dataset\Dataset;
use Datana\Iusta\Api\Domain\Value\Dataset\DatasetId;
use Datana\Iusta\Api\Domain\Value\Dataset\DatasetName;
use Datana\Iusta\Api\Domain\Value\DatasetType\DatasetTypeId;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface DatasetApiInterface
{
    /**
     * @param list<array{id: int, value: mixed}> $customFieldValues
     */
    public function create(DatasetName $name, DatasetTypeId $datasetTypeId, array $customFieldValues = []): Dataset;

    public function getByName(DatasetName $name, DatasetTypeId $datasetTypeId): Dataset;

    public function delete(DatasetId $id): ResponseInterface;
}
