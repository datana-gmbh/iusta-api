# iusta-api

| Branch    | PHP                                         |
|-----------|---------------------------------------------|
| `master`  | [![PHP][build-status-master-php]][actions]  |

## Usage

### Installation

```bash
composer require datana-gmbh/iusta-api
```

### Setup

```php
use Datana\Iusta\Api\IustaClient;

$baseUri = 'https://api.iusta...';
$username = '...';
$password = '...';
$timeout = 10; // optional

$client = new IustaClient($baseUri, $username, $password, $timeout);

// you can now request any endpoint which needs authentication
$client->request('GET', '/api/something', $options);
```

## Akten

In your code you should type-hint to `Datana\Iusta\Api\AktenApiInterface`

### Get by Aktenzeichen (`string`)

```php
use Datana\Iusta\Api\AktenApi;
use Datana\Iusta\Api\IustaClient;
use Datana\Iusta\Api\Domain\Value\DatapoolId;

$client = new IustaClient(/* ... */);

$aktenApi = new AktenApi($client);
$response = $aktenApi->getByAktenzeichen('AZ-123-Mustermann');

/*
 * to get the IustaId transform the response to array
 * and use the 'id' key.
 */
$akten = $response->toArray();
$iustaId = IustaId::fromInt($akte['id']);
```

### Get one by Aktenzeichen (`string`) or get an exception

```php
use Datana\Iusta\Api\AktenApi;
use Datana\Iusta\Api\IustaClient;
use Datana\Iusta\Api\Domain\Value\IustaId;

$client = new IustaClient(/* ... */);

$aktenApi = new AktenApi($client);

// is an instance of AktenResponse
$result = $aktenApi->getOneByAktenzeichen('1abcde-1234-5678-Mustermann');
/*
 * $response->toArray():
 *   [
 *     'id' => 123,
 *     ...
 *   ]
 *
 * or use the dedicated getter methods like
 *  - getId(): IustaId
 * etc.
 */
```

### Get by ID (`Datana\Iusta\Api\Domain\Value\IustaId`)

```php
use Datana\Iusta\Api\AktenApi;
use Datana\Iusta\Api\IustaClient;
use Datana\Iusta\Api\Domain\Value\IustaId;

$client = new IustaClient(/* ... */);

$aktenApi = new AktenApi($client);

$id = IustaId::fromInt(123);

$aktenApi->getById($id);
```

### Get E-Termin Info (`Datana\Iusta\Api\Domain\Value\IustaId`)

```php
use Datana\Iusta\Api\AktenApi;
use Datana\Iusta\Api\IustaClient;
use Datana\Iusta\Api\Domain\Value\IustaId;

$client = new IustaClient(/* ... */);

$aktenApi = new AktenApi($client);

$id = IustaId::fromInt(123);

/* @var $response Datana\Iusta\Api\Domain\Response\EterminInfoResponse */
$response = $aktenApi->getETerminInfo($id);
/*
 * $response->toArray():
 *   [
 *     'service_id' => 123,
 *     'service_url' => 'https://www.etermin.net/Gansel-Rechtsanwaelte/serviceid/123',
 *   ]
 *
 * or use the dedicated getter methods like
 *  - getServiceId()
 *  - getServiceUrl()
 * etc.
 */
```

### Get SimplyBook Info (`Datana\Iusta\Api\Domain\Value\IustaId`)

```php
use Datana\Iusta\Api\AktenApi;
use Datana\Iusta\Api\IustaClient;
use Datana\Iusta\Api\Domain\Value\IustaId;

$client = new IustaClient(/* ... */);

$aktenApi = new AktenApi($client);

$id = IustaId::fromInt(123);

/* @var $response Datana\Iusta\Api\Domain\Response\SimplyBookInfoResponse */
$response = $aktenApi->getETerminInfo($id);
/*
 * $response->toArray():
 *   [
 *     'service_id' => 12,
 *     'service_url' => 'https://ganselrechtsanwaelteag.simplybook.it/v2/#book/service/12/count/1/provider/any/',
 *   ]
 *
 * or use the dedicated getter methods like
 *  - getServiceId()
 *  - getServiceUrl()
 * etc.
 */
```

[build-status-master-php]: https://github.com/datana-gmbh/iusta-api/workflows/PHP/badge.svg?branch=master

[actions]: https://github.com/datana-gmbh/iusta-api/actions
