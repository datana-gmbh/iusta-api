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
$token = '...';
$timeout = 10; // optional

$client = new IustaClient($baseUri, $token, $timeout);

// you can now request any endpoint which needs authentication
$client->request('GET', '/api/something', $options);
```

## Cases

In your code you should type-hint to `Datana\Iusta\Api\CaseApiInterface`

### Get by ID (`Datana\Iusta\Api\Domain\Value\CaseId`)

```php
use Datana\Iusta\Api\CaseApi;
use Datana\Iusta\Api\Domain\Value\Case\CaseId;
use Datana\Iusta\Api\IustaClient;

$client = new IustaClient(/* ... */);

$api = new CaseApi($client);

$api->getById(new CaseId(123));
```

## Import

In your code you should type-hint to `Datana\Iusta\Api\ImportApiInterface`

### New case (`Datana\Iusta\Api\Domain\Value\CaseId`)

```php
use Datana\Iusta\Api\ImportApi;
use Datana\Iusta\Api\IustaClient;

$client = new IustaClient(/* ... */);

$api = new ImportApi($client);

$api->newCase(/* ... */);
```

[build-status-master-php]: https://github.com/datana-gmbh/iusta-api/workflows/PHP/badge.svg?branch=master

[actions]: https://github.com/datana-gmbh/iusta-api/actions
