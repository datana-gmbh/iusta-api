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

/**
 * @phpstan-type Values array{
 *     id: int,
 *     createdAt: string,
 *     updatedAt: string,
 *     createdBy: int,
 *     updatedBy: int
 * }
 */
final readonly class Document
{
    public DocumentId $id;

    /**
     * @param Values $values
     */
    public function __construct(
        public array $values,
    ) {
        Assert::keyExists($values, 'id');
        Assert::integer($values['id']);
        $this->id = new DocumentId($values['id']);
    }
}
