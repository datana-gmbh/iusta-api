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

use Datana\Iusta\Api\Domain\Value\CustomField\CustomField;
use Datana\Iusta\Api\Domain\Value\CustomField\CustomFieldName;
use Datana\Iusta\Api\Domain\Value\CustomField\Shortcode;
use Datana\Iusta\Api\Domain\Value\CustomField\Type;
use Datana\Iusta\Api\Domain\Value\Fieldgroup\FieldgroupId;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface CustomFieldApiInterface
{
    /**
     * @param null|array<string> $selectOptions
     */
    public function create(CustomFieldName $name, Shortcode $shortcode, Type $type, FieldgroupId $fieldgroupId, ?int $sort = null, ?string $description = null, ?string $regexp = null, ?array $selectOptions = null): CustomField;

    public function get(CustomFieldName $name): CustomField;

    public function getByShortcode(Shortcode $shortcode): CustomField;
}
