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

namespace Datana\Iusta\Api\Domain\Value\CustomField;

use Datana\Iusta\Api\Domain\Value\Fieldgroup\FieldgroupId;
use Webmozart\Assert\Assert;

final readonly class CustomField
{
    public CustomFieldId $id;
    public CustomFieldName $name;
    public Type $type;
    public FieldgroupId $customFieldGroupId;
    public ?Shortcode $shortcode;
    public ?Metadata $metdata;
    public ?Description $description;
    public ?SectionHeading $sectionHeading;
    public ?CompoundType $compoundType;
    public ?RegExp $regExp;
    public ?int $sort;

    /**
     * @var null|array<array{value: string, text: string}>
     */
    public ?array $selectOptions;
    public ?HtmlContent $htmlContent;
    public ?CustomerPointerProperty $customerPointerProperty;
    public ?VisibilityCondition $visibilityCondition;
    public ?CustomFieldPointerId $customFieldPointerId;

    /**
     * @param array{
     *     id: int,
     *     type: int,
     *     customFieldGroupId: int,
     *     shortcode: null|string,
     *     metadata?: null|string,
     *     name: string,
     *     description?: null|string,
     *     sectionHeading?: null|string,
     *     compoundType: null|string,
     *     regExp?: null|string,
     *     sort: null|int,
     *     selectOptions?: null|array<array{value: string, text: string}>,
     *     htmlContent?: null|string,
     *     customerPointerProperty?: null|string,
     *     visibilityCondition?: null|string,
     *     customFieldPointerId?: null|int,
     *     createdAt: string,
     *     updatedAt: string,
     *     createdBy: int,
     *     updatedBy: int,
     * } $values
     */
    public function __construct(
        public array $values,
    ) {
        Assert::keyExists($values, 'id');
        Assert::integer($values['id']);
        $this->id = new CustomFieldId($values['id']);

        Assert::keyExists($values, 'name');
        Assert::string($values['name']);
        $this->name = new CustomFieldName($values['name']);

        Assert::keyExists($values, 'type');
        Assert::integer($values['type']);
        $this->type = Type::from($values['type']);

        Assert::keyExists($values, 'customFieldGroupId');
        Assert::integer($values['customFieldGroupId']);
        $this->customFieldGroupId = new FieldgroupId($values['customFieldGroupId']);

        Assert::nullOrString($values['shortcode']);
        $this->shortcode = null === $values['shortcode'] ? null : new Shortcode($values['shortcode']);

        $metadata = null;

        if (\array_key_exists('metadata', $values)) {
            Assert::nullOrString($values['metadata']);
            $metadata = null === $values['metadata'] ? null : new Metadata($values['metadata']);
        }

        $this->metdata = $metadata;

        $description = null;

        if (\array_key_exists('description', $values)) {
            Assert::nullOrString($values['description']);
            $description = null === $values['description'] ? null : new Description($values['description']);
        }

        $this->description = $description;

        $sectionHeading = null;

        if (\array_key_exists('sectionHeading', $values)) {
            Assert::nullOrString($values['sectionHeading']);
            $sectionHeading = null === $values['sectionHeading'] ? null : new SectionHeading($values['sectionHeading']);
        }

        $this->sectionHeading = $sectionHeading;

        Assert::nullOrString($values['compoundType']);
        $this->compoundType = null === $values['compoundType'] ? null : new CompoundType($values['compoundType']);

        $regExp = null;

        if (\array_key_exists('regExp', $values)) {
            Assert::nullOrString($values['regExp']);
            $regExp = null === $values['regExp'] ? null : new RegExp($values['regExp']);
        }

        $this->regExp = $regExp;

        Assert::nullOrInteger($values['sort']);
        $this->sort = null === $values['sort'] ? null : $values['sort'];

        $selectOptions = null;

        if (\array_key_exists('selectOptions', $values)) {
            Assert::nullOrIsArray($values['selectOptions']);
            $selectOptions = null === $values['selectOptions'] ? null : $values['selectOptions'];
        }

        $this->selectOptions = $selectOptions;

        $htmlContent = null;

        if (\array_key_exists('htmlContent', $values)) {
            Assert::nullOrString($values['htmlContent']);
            $htmlContent = null === $values['htmlContent'] ? null : new HtmlContent($values['htmlContent']);
        }

        $this->htmlContent = $htmlContent;

        $customerPointerProperty = null;

        if (\array_key_exists('customerPointerProperty', $values)) {
            Assert::nullOrString($values['customerPointerProperty']);
            $customerPointerProperty = null === $values['customerPointerProperty'] ? null : new CustomerPointerProperty($values['customerPointerProperty']);
        }

        $this->customerPointerProperty = $customerPointerProperty;

        $visibilityCondition = null;

        if (\array_key_exists('visibilityCondition', $values)) {
            Assert::nullOrString($values['visibilityCondition']);
            $visibilityCondition = null === $values['visibilityCondition'] ? null : new VisibilityCondition($values['visibilityCondition']);
        }

        $this->visibilityCondition = $visibilityCondition;

        $customFieldPointerId = null;

        if (\array_key_exists('customFieldPointerId', $values)) {
            Assert::nullOrInteger($values['customFieldPointerId']);
            $customFieldPointerId = null === $values['customFieldPointerId'] ? null : new CustomFieldPointerId($values['customFieldPointerId']);
        }

        $this->customFieldPointerId = $customFieldPointerId;
    }
}
