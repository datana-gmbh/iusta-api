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

namespace Datana\Iusta\Api\Domain\Value\Deadline;

use Safe\DateTimeImmutable;
use Webmozart\Assert\Assert;

final readonly class Deadline
{
    public DeadlineId $id;
    public DeadlineName $name;
    public Status $status;
    public DateTimeImmutable $dueAt;
    public ?DateTimeImmutable $preDueAt;
    public ?string $comment;

    /**
     * @param array{
     *     id: positive-int,
     *     name: string,
     *     status: integer,
     *     dueAt: string,
     *     preDueAt: null|string,
     *     comment: null|string,
     *     createdAt: string,
     *     updatedAt: string,
     *     createdBy: int,
     *     updatedBy: int
     * } $values
     */
    public function __construct(
        public array $values,
    ) {
        Assert::keyExists($values, 'id');
        Assert::integer($values['id']);
        $this->id = new DeadlineId($values['id']);

        Assert::keyExists($values, 'name');
        Assert::string($values['name']);
        $this->name = new DeadlineName($values['name']);

        Assert::keyExists($values, 'status');
        Assert::integer($values['status']);
        $this->status = Status::from($values['status']);

        Assert::keyExists($values, 'dueAt');
        Assert::string($values['dueAt']);
        $this->dueAt = new DateTimeImmutable($values['dueAt']);

        Assert::keyExists($values, 'preDueAt');
        Assert::nullOrString($values['preDueAt']);
        $this->preDueAt = null === $values['preDueAt'] ? null : new DateTimeImmutable($values['preDueAt']);

        Assert::keyExists($values, 'comment');
        Assert::nullOrString($values['comment']);
        $this->comment = $values['comment'];
    }
}
