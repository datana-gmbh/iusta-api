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

namespace Datana\Iusta\Api;

use Datana\Iusta\Api\Domain\Value\DocumentCategory\DocumentCategory;
use Datana\Iusta\Api\Domain\Value\DocumentCategory\DocumentCategoryName;
use Datana\Iusta\Api\Exception\DocumentCategoryNotFoundException;
use Datana\Iusta\Api\Exception\MoreThanOneDocumentCategoryFoundException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class DocumentCategoryApi implements DocumentCategoryApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function create(DocumentCategoryName $name): DocumentCategory
    {
        $response = $this->client->request(
            'POST',
            '/api/DocumentCategories',
            [
                'json' => [
                    'name' => $name->toString(),
                ],
            ],
        );

        return new DocumentCategory($response->toArray());
    }

    public function get(DocumentCategoryName $name): DocumentCategory
    {
        $response = $this->client->request(
            'GET',
            '/api/DocumentCategories',
            [
                'query' => [
                    'filter' => \Safe\json_encode([
                        'where' => [
                            'name' => $name->toString(),
                        ],
                    ]),
                ],
            ],
        );

        $array = $response->toArray();

        if (!\array_key_exists(0, $array)) {
            throw DocumentCategoryNotFoundException::forName($name);
        }

        if (\count($array) > 1) {
            throw MoreThanOneDocumentCategoryFoundException::forName($name);
        }

        return new DocumentCategory($array[0]);
    }
}
