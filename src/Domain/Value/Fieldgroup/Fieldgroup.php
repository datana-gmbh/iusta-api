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

namespace Datana\Iusta\Api\Domain\Value\Fieldgroup;

use Webmozart\Assert\Assert;

final readonly class Fieldgroup
{
    public FieldgroupId $id;
    public FieldgroupName $name;
    public ?int $sort;

    /**
     * @param array{
     *     id: int,
     *     name: string,
     *     shortcode?: null|string,
     *     sort?: null|int,
     *     referenceId?: null|int,
     *     referenceType?: null|string,
     *     createdAt: string,
     *     updatedAt: string,
     *     createdBy: int,
     *     updatedBy: int
     * } $values
     */
    public function __construct(
        public array $values,
    ) {
        Assert::keyExists($values, 'id');
        Assert::integer($values['id']);
        $this->id = new FieldgroupId($values['id']);

        Assert::keyExists($values, 'name');
        Assert::string($values['name']);
        $this->name = new FieldgroupName($values['name']);

        $sort = null;

        if (\array_key_exists('sort', $values)) {
            Assert::nullOrInteger($values['sort']);
            $sort = $values['sort'];
        }

        $this->sort = $sort;
    }
}
