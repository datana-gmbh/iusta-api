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

namespace Datana\Iusta\Api\Bridge\Faker;

use Datana\Iusta\Api\Domain\Value\IustaId;
use Faker\Provider\Base as BaseProvider;

final class IustaIdProvider extends BaseProvider
{
    public function datapoolId(): IustaId
    {
        return IustaId::fromInt(
            $this->datapoolIdInteger(),
        );
    }

    public function datapoolIdInteger(): int
    {
        return $this->generator->numberBetween(1);
    }
}
