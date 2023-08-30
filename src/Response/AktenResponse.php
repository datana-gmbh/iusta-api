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

namespace Datana\Iusta\Api\Response;

use Datana\Iusta\Api\Domain\Value\IustaId;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;

final class AktenResponse
{
    public ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getId(): IustaId
    {
        $response = $this->toArray();

        Assert::notEmpty($response);
        Assert::keyExists($response, 'id');
        Assert::integer($response['id']);

        return IustaId::fromInt($response['id']);
    }

    public function toArray(): array
    {
        $array = $this->response->toArray();

        Assert::notEmpty($array);
        Assert::keyExists($array, 'hydra:member');
        Assert::notEmpty($array['hydra:member']);
        Assert::keyExists($array['hydra:member'], 0);
        Assert::notEmpty($array['hydra:member'][0]);

        return $array['hydra:member'][0];
    }
}
