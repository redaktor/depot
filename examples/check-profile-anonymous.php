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

echo "Canonical Entity URI:\n";
echo $server->entity()->uri()."\n";
echo "\n";

echo "Available Profile Info Types:\n";
print_r($server->entity()->profileInfoTypes());
echo "\n";

$coreProfileInfo = $server->entity()->findProfileInfo(
    'https://tent.io/types/info/core/v0.1.0'
);

echo "Core Profile Info:\n";
print_r($coreProfileInfo->content());
echo "\n";

$basicProfileInfo = $server->entity()->findProfileInfo(
    'https://tent.io/types/info/basic/v0.1.0'
);

echo "Basic Profile Info:\n";
print_r($basicProfileInfo->content());
echo "\n";
