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

use Datana\Iusta\Api\Domain\Value\DocumentCategory\DocumentCategoryId;
use Webmozart\Assert\Assert;

final readonly class Document
{
    public DocumentId $id;
    public DocumentCategoryId $documentCategoryId;

    /**
     * @param array{createdDocument: Values}|Values $values
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

        Assert::keyExists($values, 'documentCategoryId');
        Assert::integer($values['documentCategoryId']);
        $this->documentCategoryId
    }
}
