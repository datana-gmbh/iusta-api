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
use Datana\Iusta\Api\Exception\CustomFieldNotFoundException;
use Datana\Iusta\Api\Exception\MoreThanOneCustomFieldFoundException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class CustomFieldApi implements CustomFieldApiInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private IustaClient $client,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function create(CustomFieldName $name, Shortcode $shortcode, Type $type, FieldgroupId $fieldgroupId, ?int $sort = null, ?string $description = null, ?string $regexp = null, ?array $selectOptions = null): CustomField
    {
        $response = $this->client->request(
            'POST',
            '/api/CustomFields',
            [
                'json' => array_filter([
                    'name' => $name->toString(),
                    'shortcode' => $shortcode->toString(),
                    'type' => $type->getId(),
                    'customFieldGroupId' => $fieldgroupId->toInt(),
                    'sort' => $sort,
                    'description' => $description,
                    'regexp' => $regexp,
                    'selectOptions' => $selectOptions,
                ]),
            ],
        );

        return new CustomField($response->toArray());
    }

    public function get(CustomFieldName $name): CustomField
    {
        $response = $this->client->request(
            'GET',
            '/api/CustomFields',
            [
                'query' => [
                    'filter' => \Safe\json_encode([
                        'where' => [
                            'name' => $name->toString(),
                        ],
                    ]),
                ],
            ],
        );

        $array = $response->toArray();

        if (!\array_key_exists(0, $array)) {
            throw CustomFieldNotFoundException::forName($name);
        }

        if (\count($array) > 1) {
            throw MoreThanOneCustomFieldFoundException::forName($name);
        }

        return new CustomField($array[0]);
    }

    public function getByShortcode(Shortcode $shortcode): CustomField
    {
        $response = $this->client->request(
            'GET',
            '/api/CustomFields',
            [
                'query' => [
                    'filter' => \Safe\json_encode([
                        'where' => [
                            'shortcode' => $shortcode->toString(),
                        ],
                    ]),
                ],
            ],
        );

        $array = $response->toArray();

        if (!\array_key_exists(0, $array)) {
            throw CustomFieldNotFoundException::forShortcode($shortcode);
        }

        if (\count($array) > 1) {
            throw MoreThanOneCustomFieldFoundException::forShortcode($shortcode);
        }

        return new CustomField($array[0]);
    }
}
