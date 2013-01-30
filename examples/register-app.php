<?php

require_once __DIR__.'/../vendor/autoload.php';

use Depot\Api\Client;
use Depot\Core\Domain\Model\App;
use Depot\Core\Domain\Model\Auth;

$app = new App\App(
    'depot-testapp',
    'Test of the Depot client',
    'http://testapp.depot.io',
    'http://testapp.depot.io/icon.png',
    array('http://testapp.depot.io/tent/callback'),
    array(
        'read_profile' => 'Read all the profiles',
        'write_profile' => 'Write all the profiles',
        'read_posts' => 'Read all the posts',
        'write_posts' => 'Write all the posts',
    )
);

if (count($argv) < 2) {
    print "Usage: register-app.php [entity_uri]\n";
    exit;
}

$entityUri = $argv['1'];

// Create the client.
$client = Client\ClientFactory::create();

// Find the Server (Entity container)
$server = $client->discover($entityUri);

// Register our application with the server.
$appRegistrationCreationResponse = $client->app()->register($server, $app);

// Capture the application's auth credentials.
$auth = $appRegistrationCreationResponse->auth();

// Construct the Client APP (can be persisted at this point)
$clientApp = new App\ClientApp(
    $appRegistrationCreationResponse->id(),
    $app,
    $auth
);

// TODO: Not needed (can fallback to clientApp->app->redirectUris->first)
$redirectUri = 'http://testapp.depot.io/tent/callback';

// Generate the Client Authorization Request (state + URL; can be persisted)
$clientAuthorizationRequest = $client->app()->generateClientAuthorizationRequest(
    $server,
    $clientApp,
    $redirectUri, // TODO: Not needed if using configured defaults
    array('read_profile', 'write_profile', 'read_posts', 'write_posts'), // TODO: Not needed if using configured defaults
    array(
        'https://tent.io/types/info/basic/v0.1.0',
    ),
    array(
        'https://tent.io/types/post/status/v0.1.0',
        'https://tent.io/types/post/essay/v0.1.0',
        'https://tent.io/types/post/repost/v0.1.0',
        'https://tent.io/types/post/follower/v0.1.0',
        'https://tent.io/types/post/following/v0.1.0',
    )
);

print "Please open this URL and enter the code and state embedded in the redirect link\n\n";
print $clientAuthorizationRequest->url()."\n\n";
print "Code: ";

$code = trim(fgets(STDIN));

print "State: ";

$state = trim(fgets(STDIN));

print "\n";

if ($state !== $clientAuthorizationRequest->state()) {
    throw new \RuntimeException("Invalid state; abandoning authorization");
}

$clientAuthorizationResponse = $client->authenticate($auth)->app()->exchangeCode(
    $server,
    $clientApp,
    $code
);

print 'App ID: '.$clientApp->id()."\n";

print "\n";

print 'App MAC Key ID: '.$clientApp->auth()->macKeyId()."\n";
print 'App MAC Key: '.$clientApp->auth()->macKey()."\n";

print "\n";

print 'Authorization MAC Key ID: '.$clientAuthorizationResponse->auth()->macKeyId()."\n";
print 'Authorization MAC Key: '.$clientAuthorizationResponse->auth()->macKey()."\n";

print "\n";

$appConfig = array(
    'app_id' => $clientApp->id(),

    'app_mac_key_id' => $clientApp->auth()->macKeyId(),
    'app_mac_key' => $clientApp->auth()->macKey(),

    'authz_mac_key_id' => $clientAuthorizationResponse->auth()->macKeyId(),
    'authzapp_mac_key' => $clientAuthorizationResponse->auth()->macKey(),

    'entity_uri' => $entityUri,
);

file_put_contents(__DIR__.'/.tent-credentials.json', json_encode($appConfig));
