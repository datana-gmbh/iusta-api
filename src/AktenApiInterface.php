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

use Datana\Iusta\Api\Domain\Value\IustaId;
use Datana\Iusta\Api\Response\AktenResponse;
use Datana\Iusta\Api\Response\ETerminInfoResponse;
use Datana\Iusta\Api\Response\SimplyBookInfoResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface AktenApiInterface
{
    public function getById(IustaId $iustaId): ResponseInterface;

    public function getByAktenzeichen(string $aktenzeichen): ResponseInterface;

    public function getOneByAktenzeichen(string $aktenzeichen): AktenResponse;

    public function getETerminInfo(IustaId $iustaId): ETerminInfoResponse;

    public function getSimplyBookInfo(IustaId $iustaId): SimplyBookInfoResponse;
}
