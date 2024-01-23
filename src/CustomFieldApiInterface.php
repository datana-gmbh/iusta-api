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

use Datana\Iusta\Api\Domain\Value\CustomField\CompoundType;
use Datana\Iusta\Api\Domain\Value\CustomField\CustomField;
use Datana\Iusta\Api\Domain\Value\CustomField\CustomFieldName;
use Datana\Iusta\Api\Domain\Value\CustomField\Description;
use Datana\Iusta\Api\Domain\Value\CustomField\RegExp;
use Datana\Iusta\Api\Domain\Value\CustomField\Shortcode;
use Datana\Iusta\Api\Domain\Value\CustomField\Type;
use Datana\Iusta\Api\Domain\Value\Fieldgroup\FieldgroupId;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface CustomFieldApiInterface
{
    /**
     * @param null|array<array{value: string, text: string}> $selectOptions
     */
    public function create(
        CustomFieldName $name,
        Shortcode $shortcode,
        Type $type,
        FieldgroupId $fieldgroupId,
        ?int $sort = null,
        ?Description $description = null,
        ?RegExp $regexp = null,
        ?array $selectOptions = null,
        ?CompoundType $compoundType = null,
    ): CustomField;

    public function getByName(CustomFieldName $name, ?FieldgroupId $fieldgroupId = null): CustomField;

    public function getByShortcode(Shortcode $shortcode): CustomField;
}
