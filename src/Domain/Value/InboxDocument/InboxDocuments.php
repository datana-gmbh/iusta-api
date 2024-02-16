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

final readonly class InboxDocuments
{
    /**
     * @var array<InboxDocument>
     */
    public array $documents;

    /**
     * @param list<array<mixed>> $response
     */
    public function __construct(array $response)
    {
        $documents = [];

        foreach ($response as $document) {
            $documents[] = new InboxDocument($document);
        }

        $this->documents = $documents;
    }
}
