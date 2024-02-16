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

namespace Datana\Iusta\Api\Domain\Value\InboxDocument;

use Webmozart\Assert\Assert;

/**
 * @phpstan-type Values array{
 *     id: int,
 *     categoryId: int,
 *     createdAt: string,
 *     updatedAt: string,
 *     createdBy: int,
 *     updatedBy: int
 * }
 */
final readonly class InboxDocument
{
    public InboxDocumentId $id;
    public InboxDocumentCategoryId $categoryId;

    /**
     * @param Values $values
     */
    public function __construct(
        public array $values,
    ) {
        Assert::keyExists($values, 'id');
        Assert::integer($values['id']);
        $this->id = new InboxDocumentId($values['id']);

        Assert::keyExists($values, 'categoryId');
        Assert::integer($values['categoryId']);
        $this->categoryId = new InboxDocumentCategoryId($values['categoryId']);
    }
}
