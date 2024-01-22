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
    /** @var array<array{value: string, text: string}>|null */
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
     *     metadata: null|string,
     *     name: string,
     *     description: null|string,
     *     sectionHeading: null|string,
     *     compoundType: null|int,
     *     regExp: null|string,
     *     sort: null|int,
     *     selectOptions: null|array<array{value: string, text: string}>,
     *     htmlContent: null|string,
     *     customerPointerProperty: null|string,
     *     visibilityCondition: null|string,
     *     customFieldPointerId: null|int,
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

        Assert::nullOrString($values['metadata']);
        $this->metdata = null === $values['metadata'] ? null : new Metadata($values['metadata']);

        Assert::nullOrString($values['description']);
        $this->description = null === $values['description'] ? null : new Description($values['description']);

        Assert::nullOrString($values['sectionHeading']);
        $this->sectionHeading = null === $values['sectionHeading'] ? null : new SectionHeading($values['sectionHeading']);

        Assert::nullOrInteger($values['compoundType']);
        $this->compoundType = null === $values['compoundType'] ? null : new CompoundType($values['compoundType']);

        Assert::nullOrString($values['regExp']);
        $this->regExp = null === $values['regExp'] ? null : new RegExp($values['regExp']);

        Assert::nullOrInteger($values['sort']);
        $this->sort = null === $values['sort'] ? null : $values['sort'];

        Assert::nullOrIsArray($values['selectOptions']);
        $this->selectOptions = null === $values['selectOptions'] ? null : $values['selectOptions'];

        Assert::nullOrString($values['htmlContent']);
        $this->htmlContent = null === $values['htmlContent'] ? null : new HtmlContent($values['htmlContent']);

        Assert::nullOrString($values['customerPointerProperty']);
        $this->customerPointerProperty = null === $values['customerPointerProperty'] ? null : new CustomerPointerProperty($values['customerPointerProperty']);

        Assert::nullOrString($values['visibilityCondition']);
        $this->visibilityCondition = null === $values['visibilityCondition'] ? null : new VisibilityCondition($values['visibilityCondition']);

        Assert::nullOrInteger($values['customFieldPointerId']);
        $this->customFieldPointerId = null === $values['customFieldPointerId'] ? null : new CustomFieldPointerId($values['customFieldPointerId']);
    }
}
