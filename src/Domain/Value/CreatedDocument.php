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

namespace Datana\Iusta\Api\Domain\Value;

use Webmozart\Assert\Assert;

final readonly class CreatedDocument
{
    public DocumentId $id;

    /**
     * @param array<mixed> $values
     */
    public function __construct(
        public array $values,
    ) {
        Assert::keyExists($values, 'id');
        $this->id = new DocumentId($values['id']);
    }
}
