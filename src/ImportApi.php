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

use Datana\Iusta\Api\Domain\Value\CreatedCase;
use Datana\Iusta\Api\Domain\Value\IustaId;
use Datana\Iusta\Api\Response\AktenResponse;
use Datana\Iusta\Api\Response\ETerminInfoResponse;
use Datana\Iusta\Api\Response\SimplyBookInfoResponse;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;
use function Safe\sprintf;

final class ImportApi implements ImportApiInterface
{
    private IustaClient $client;
    private LoggerInterface $logger;

    public function __construct(IustaClient $client, ?LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->logger = $logger ?? new NullLogger();
    }

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

            return $response;
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }
}
