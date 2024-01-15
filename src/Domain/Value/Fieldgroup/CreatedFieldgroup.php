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

namespace Datana\Iusta\Api\Domain\Value\Fieldgroup;

use Webmozart\Assert\Assert;

final readonly class CreatedFieldgroup
{
    public FieldgroupId $id;

    /**
     * @param array<mixed> $response
     */
    public function __construct(
        public array $response,
    ) {
        Assert::keyExists($response, 'createdFieldgroup');
        Assert::keyExists($response['createdFieldgroup'], 'id');
        Assert::integer($response['createdFieldgroup']['id']);

        $this->id = new FieldgroupId($response['createdFieldgroup']['id']);
    }
}
