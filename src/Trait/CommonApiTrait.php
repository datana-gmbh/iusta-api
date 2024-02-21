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

namespace Datana\Iusta\Api\Trait;

use Symfony\Component\HttpClient\Exception\JsonException;
use Symfony\Contracts\HttpClient\ResponseInterface;

trait CommonApiTrait
{
    private static function validateResponse(ResponseInterface $response): void
    {
        try {
            $response->toArray();
        } catch (JsonException $e) {
            throw new \RuntimeException('Could not call toArray on response', previous: $e);
        }

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException(sprintf('Unsuccessful response status. getContent() contains: %s', $response->getContent()));
        }
    }
}
