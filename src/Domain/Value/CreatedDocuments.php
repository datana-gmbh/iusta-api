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

final readonly class CreatedDocuments
{
    /**
     * @var array<CreatedDocument>
     */
    public array $documents;

    /**
     * @param array<mixed> $response
     */
    public function __construct(array $response)
    {
        $documents = [];

        foreach ($response as $document) {
            $documents[] = new CreatedDocument($document);
        }

        $this->documents = $documents;
    }
}
