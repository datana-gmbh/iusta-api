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

namespace Datana\Iusta\Api\Domain\Value\CaseGroup;

use Webmozart\Assert\Assert;

final readonly class CaseGroup
{
    public CaseGroupId $id;
    public CaseGroupName $name;

    /**
     * @param array{id: int, name: string, createdAt: string, updatedAt: string, createdBy: int, updatedBy: int} $values
     */
    public function __construct(
        public array $values,
    ) {
        Assert::keyExists($values, 'id');
        Assert::integer($values['id']);
        $this->id = new CaseGroupId($values['id']);

        Assert::keyExists($values, 'name');
        Assert::string($values['name']);
        $this->name = new CaseGroupName($values['name']);
    }
}
