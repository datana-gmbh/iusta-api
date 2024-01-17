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
final class MoreThanOneCustomFieldFoundException extends \RuntimeException
{
    public static function forName(CustomFieldName $name): self
    {
        return new self(sprintf(
            'More than one CustomField with name "%s" found.',
            $name->toString(),
        ));
    }

    public static function forShortcode(Shortcode $shortcode): self
    {
        return new self(sprintf(
            'More than one CustomField with shortcode "%s" found.',
            $shortcode->toString(),
        ));
    }
}
