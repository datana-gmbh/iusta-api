<?php

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
            throw new \RuntimeException('Unsuccessful response status. getContent() contains: %s', $response->getContent());
        }
    }
}
