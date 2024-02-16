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

use Datana\Iusta\Api\Domain\Value\InboxDocument\InboxDocument;
use Datana\Iusta\Api\Domain\Value\InboxDocument\InboxDocumentCategoryId;
use Datana\Iusta\Api\Domain\Value\InboxDocument\InboxDocuments;
use Datana\Iusta\Api\Exception\MoreThanOneInboxDocumentFoundException;
use Datana\Iusta\Api\Exception\NoInboxDocumentsCreatedException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Webmozart\Assert\Assert;
use function Safe\fopen;

final class InboxDocumentApi implements InboxDocumentApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function upload(string $filepath, InboxDocumentCategoryId $categoryId): InboxDocument
    {
        Assert::fileExists($filepath);

        $response = $this->client->request(
            'POST',
            sprintf('/api/InboxDocuments/createMultipleFromFile/%s', $categoryId->toInt()),
            [
                'query' => [
                    'categoryId' => $categoryId->toInt(),
                ],
                'body' => [
                    'file' => fopen($filepath, 'rb'),
                ],
                'timeout' => 100, // this call can take quite long...
            ],
        );

        $createdInboxDocuments = new InboxDocuments($response->toArray());

        $count = \count($createdInboxDocuments->documents);

        if (0 === $count) {
            throw new NoInboxDocumentsCreatedException();
        }

        if (1 < $count) {
            throw new MoreThanOneInboxDocumentFoundException();
        }

        return $createdInboxDocuments->documents[0];
    }
}
