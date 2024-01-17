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

namespace Datana\Iusta\Api\Exception;

use Datana\Iusta\Api\Domain\Value\CustomField\CustomFieldName;
use Datana\Iusta\Api\Domain\Value\CustomField\Shortcode;

/**
 * @author Oskar Stark <oskarstark@googlemail.com>
 */
final class CustomFieldNotFoundException extends \RuntimeException
{
    public static function forName(CustomFieldName $name): self
    {
        return new self(sprintf(
            'CustomField with name "%s" not found.',
            $name->toString(),
        ));
    }

    public static function forShortcode(Shortcode $shortcode): self
    {
        return new self(sprintf(
            'CustomField with shortcode "%s" not found.',
            $shortcode->toString(),
        ));
    }
}
