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

use Datana\Iusta\Api\Domain\Value\DeadlineType\DeadlineType;
use Datana\Iusta\Api\Domain\Value\DeadlineType\DeadlineTypeName;
use Datana\Iusta\Api\Exception\DeadlineTypeNotFoundException;
use Datana\Iusta\Api\Exception\MoreThanOneDeadlineTypeFoundException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class DeadlineTypeApi implements DeadlineTypeApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function create(DeadlineTypeName $name): DeadlineType
    {
        $response = $this->client->request(
            'POST',
            '/api/DeadlineTypes',
            [
                'json' => [
                    'name' => $name->toString(),
                ],
            ],
        );

        return new DeadlineType($response->toArray());
    }

    public function get(DeadlineTypeName $name): DeadlineType
    {
        $response = $this->client->request(
            'GET',
            '/api/DeadlineTypes',
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
            throw DeadlineTypeNotFoundException::forName($name);
        }

        if (\count($array) > 1) {
            throw MoreThanOneDeadlineTypeFoundException::forName($name);
        }

        return new DeadlineType($array[0]);
    }
}
