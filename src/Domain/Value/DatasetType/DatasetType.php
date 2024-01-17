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

namespace Datana\Iusta\Api\Domain\Value\DatasetType;

use Datana\Iusta\Api\Domain\Value\DatasetId;
use Datana\Iusta\Api\Domain\Value\DatasetTypeId;
use Webmozart\Assert\Assert;

final readonly class DatasetType
{
    public DatasetId $id;
    public DatasetName $name;
    public DatasetTypeId $datasetTypeId;

    /**
     * @param array{id: int, name: string, createdAt: string, updatedAt: string, createdBy: int, updatedBy: int, datasetTypeId: int} $values
     */
    public function __construct(
        public array $values,
    ) {
        Assert::keyExists($values, 'id');
        Assert::integer($values['id']);
        $this->id = new DatasetId($values['id']);

        Assert::keyExists($values, 'name');
        Assert::string($values['name']);
        $this->name = new DatasetName($values['name']);

        Assert::keyExists($values, 'datasetTypeId');
        Assert::integer($values['datasetTypeId']);
        $this->datasetTypeId = new DatasetTypeId($values['datasetTypeId']);
    }
}