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

namespace Datana\Iusta\Api\Domain\Value\Document;

use Webmozart\Assert\Assert;

final readonly class Document
{
    public DocumentId $id;

    /**
     * @param array{
     *     id: int,
     *     createdAt: string,
     *     updatedAt: string,
     *     createdBy: int,
     *     updatedBy: int
     * } $values
     */
    public function __construct(
        public array $values,
    ) {
        if (\array_key_exists('createdDocument', $values)) {
            Assert::notEmpty($values['createdDocument']);
            $values = $values['createdDocument'];
        }

        Assert::keyExists($values, 'id');
        Assert::integer($values['id']);
        $this->id = new DocumentId($values['id']);
    }
}
