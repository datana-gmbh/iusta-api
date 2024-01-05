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

use OskarStark\Value\TrimmedNonEmptyString;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;

/**
 * @author Oskar Stark <oskarstark@googlemail.com>
 */
final class IustaClient
{
    private HttpClientInterface $client;
    private LoggerInterface $logger;

    public function __construct(
        string $baseUri,
        #[\SensitiveParameter()]
        private string $token,
        private int $timeout = 2,
        ?LoggerInterface $logger = null,
    ) {
        $this->client = HttpClient::createForBaseUri($baseUri);
        TrimmedNonEmptyString::fromString($token, '$token must not be an empty string')->toString();
        $this->logger = $logger ?? new NullLogger();
    }

    /**
     * Requests an HTTP resource.
     *
     * Responses MUST be lazy, but their status code MUST be
     * checked even if none of their public methods are called.
     *
     * Implementations are not required to support all options described above; they can also
     * support more custom options; but in any case, they MUST throw a TransportExceptionInterface
     * when an unsupported option is passed.
     *
     * @param array<mixed> $options
     *
     * @throws TransportExceptionInterface When an unsupported option is passed
     */
    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        Assert::notStartsWith($url, 'http', '$url should be relative: Got: %s');
        Assert::startsWith($url, '/', '$url should start with a "/". Got: %s');

        if (!\array_key_exists('timeout', $options)) {
            $options['timeout'] = $this->timeout;
        }

        try {
            $this->logger->debug(sprintf('Request %s %s', $method, $url), $options);

            $response = $this->client->request(
                $method,
                $url,
                array_merge_recursive(
                    $options,
                    [
                        'headers' => [
                            'Authorization' => $this->token,
                        ],
                    ],
                ),
            );

            $this->logger->debug(
                sprintf('Response %s %s %s', $response->getStatusCode(), $method, $url),
                $response->toArray(false),
            );
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }

        return $response;
    }
}
