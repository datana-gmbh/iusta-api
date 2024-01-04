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

use Datana\Iusta\Api\Domain\Value\CaseId;
use Datana\Iusta\Api\Domain\Value\CreatedCase;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;

final class ImportApi implements ImportApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    /**
     * {@inheritDoc}
     */
    public function newCase(array $payload): CreatedCase
    {
        Assert::notEmpty($payload);

        try {
            $response = $this->client->request(
                'POST',
                '/api/Imports/v2/newCase',
                [
                    'json' => $payload,
                ],
            );

            $this->logger->debug('Response', $response->toArray(false));

            return new CreatedCase($response->toArray());
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function updateCase(CaseId $id, array $customFieldvalues = []): ResponseInterface
    {
        Assert::notEmpty($customFieldvalues);

        $payload = [
            'customFieldValues' => $customFieldvalues,
        ];

        try {
            $response = $this->client->request(
                'POST',
                sprintf('/api/Imports/v2/updateCase/%s', $id->toInt()),
                [
                    'json' => $payload,
                ],
            );

            $this->logger->debug('Response', $response->toArray(false));

            return $response;
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }
}
