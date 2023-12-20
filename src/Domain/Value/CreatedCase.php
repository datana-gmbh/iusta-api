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

namespace Datana\Iusta\Api\Domain\Value;

use Webmozart\Assert\Assert;

final readonly class CreatedCase
{
    public CaseId $id;

    /**
     * @param array<mixed> $response
     */
    public function __construct(
        public array $response,
    ) {
        Assert::keyExists($response, 'createdCase');
        Assert::keyExists($response['createdCase'], 'id');

        $this->id = new CaseId($response['createdCase']['id']);
    }
}
