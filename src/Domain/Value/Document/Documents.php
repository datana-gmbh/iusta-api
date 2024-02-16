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

/**
 * @phpstan-import-type Values from Document
 */
final readonly class Documents
{
    /**
     * @var array<Document>
     */
    public array $documents;

    /**
     * @param list<Values> $response
     */
    public function __construct(array $response)
    {
        $documents = [];

        foreach ($response as $document) {
            $documents[] = new Document($document);
        }

        $this->documents = $documents;
    }
}
