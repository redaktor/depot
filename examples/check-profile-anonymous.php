<?php

require_once __DIR__.'/../vendor/autoload.php';

use Depot\Api\Client;

if (count($argv) < 2) {
    echo "Usage: check-profile-anonymous.php [entity_uri]\n";
    exit;
}

$entityUri = $argv['1'];

$clientFactory = new Client\ClientFactory;
$client = $clientFactory->create();

// Find the Server (Entity container)
$server = $client->discover($entityUri);

echo "Available Types:\n";
print_r($server->entity()->profile()->types());
echo "\n";

$coreProfile = $server->entity()->profile()->find(
    'https://tent.io/types/info/core/v0.1.0'
);

echo "Core Profile:\n";
print_r($coreProfile->content());
echo "\n";

$basicProfile = $server->entity()->profile()->find(
    'https://tent.io/types/info/basic/v0.1.0'
);

echo "Basic Profile:\n";
print_r($basicProfile->content());
echo "\n";
