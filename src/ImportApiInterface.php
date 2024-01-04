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
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface ImportApiInterface
{
    /**
     * @param array<mixed> $payload
     */
    public function newCase(array $payload): CreatedCase;

    /**
     * @param array<array{id: int, value: int|list<string>|string}> $customFieldvalues
     */
    public function updateCase(CaseId $id, array $customFieldvalues = []): ResponseInterface;
}
