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

/**
 * @author Oskar Stark <oskarstark@googlemail.com>
 */
final class NoInboxDocumentsCreatedException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('No InboxDocuments created.');
    }
}
