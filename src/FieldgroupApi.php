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

use Datana\Iusta\Api\Domain\Value\Dataset\FieldgroupName;
use Datana\Iusta\Api\Domain\Value\Fieldgroup\Fieldgroup;
use Datana\Iusta\Api\Exception\FieldgroupNotFoundException;
use Datana\Iusta\Api\Exception\MoreThanOneFieldgroupFoundException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class FieldgroupApi implements FieldgroupApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function get(FieldgroupName $name): Fieldgroup
    {
        $response = $this->client->request(
            'GET',
            '/api/CustomFieldGroups',
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
            throw FieldgroupNotFoundException::forName($name);
        }

        if (\count($array) > 1) {
            throw MoreThanOneFieldgroupFoundException::forName($name);
        }

        return new Fieldgroup($array[0]);
    }
}
