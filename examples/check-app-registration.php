<?php

require_once __DIR__.'/../vendor/autoload.php';

use Depot\Api\Client;
use Depot\Core\Domain\Model\App;
use Depot\Core\Domain\Model\Auth;

$appConfig = file_exists(__DIR__.'/.tent-credentials.json')
    ? json_decode(file_get_contents(__DIR__.'/.tent-credentials.json'), true)
    : $appConfig = array(
        'app_id' => 'XXXXXX',

        'app_mac_key_id' => 'a:YYYYYYY',
        'app_mac_key' => 'ABCDEF001122334455',

        'authz_mac_key_id' => 'u:AAA-BBB-CCC',
        'authzapp_mac_key' => '01AA02BB03CC04DD05',

        'entity_uri' => 'https://depot-testapp.tent.is',
    );

$app = new App\App(
    'depot-testapp',
    'Test of the Depot client',
    'http://testapp.depot.io',
    'http://testapp.depot.io/icon.png',
    array('http://testapp.depot.io/tent/callback'),
    array(
        'read_profile' => 'Read all the profiles',
        'write_profile' => 'Write all the profiles',
    )
);

$authFactory = new Auth\AuthFactory;
$auth = $authFactory->create($appConfig['app_mac_key_id'], $appConfig['app_mac_key']);

$clientApp = new App\ClientApp(
    $appConfig['app_id'],
    $app,
    $auth
);

// Create the client.
$client = Client\ClientFactory::create();

// Find the Server (Entity container)
$server = $client->discover($appConfig['entity_uri']);

$appRegistrationResponse = $client->authenticate($auth)->app()->get(
    $server,
    $clientApp
);

$clientApp->app()->setScope('write_profile', 'Write all the profiles (changed)');

$appRegistrationResponse = $client->authenticate($auth)->app()->put(
    $server,
    $clientApp
);

print_r($appRegistrationResponse);
