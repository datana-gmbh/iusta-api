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
use Datana\Iusta\Api\Response\KtAktenInfoResponse;
use Datana\Iusta\Api\Response\SachstandResponse;
use Datana\Iusta\Api\Response\SimplyBookInfoResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @author Oskar Stark <oskar.stark@googlemail.de>
 */
interface AktenApiInterface
{
    public function getById(IustaId $datapoolId): ResponseInterface;

    public function getByAktenzeichen(string $aktenzeichen): ResponseInterface;

    public function getOneByAktenzeichen(string $aktenzeichen): AktenResponse;

    public function getETerminInfo(IustaId $datapoolId): ETerminInfoResponse;

    public function getSimplyBookInfo(IustaId $datapoolId): SimplyBookInfoResponse;

    public function getKtAktenInfo(IustaId $datapoolId): KtAktenInfoResponse;

    public function getSachstand(IustaId $datapoolId): SachstandResponse;

    public function search(string $searchTerm): ResponseInterface;

    public function getByFahrzeugIdentifikationsnummer(string $fahrzeugIdentifikationsnummer): ResponseInterface;

    /**
     * Diese Methode setzt "Ja" in KT beim Feld "Nutzer Mandantencockpit", das bedeutet,
     * dass nur noch das Mandantencockpit für die Benachrichtigungen an den User zuständig ist.
     *
     * Andere Systeme wie KT, Formulario, VWV senden dann keine E-Mails oder SMS mehr an den Mandanten!
     */
    public function setValueNutzerMandantencockpit(IustaId $datapoolId, bool $value): bool;
}
