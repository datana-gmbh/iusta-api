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

namespace Datana\Iusta\Api\Domain\Value\DeadlineType;

use Webmozart\Assert\Assert;

final readonly class DeadlineType
{
    public DeadlineId $id;
    public DeadlineTypeName $name;

    /**
     * @param array{id: positive-int, name: string, prefillReferenceNumberCustomFields: array<mixed>, preselectAssignedUserId: positive-int, createdAt: string, updatedAt: string, createdBy: int, updatedBy: int} $values
     */
    public function __construct(
        public array $values,
    ) {
        Assert::keyExists($values, 'id');
        Assert::integer($values['id']);
        $this->id = new DeadlineId($values['id']);

        Assert::keyExists($values, 'name');
        Assert::string($values['name']);
        $this->name = new DeadlineTypeName($values['name']);
    }
}
