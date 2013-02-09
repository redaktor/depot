<?php

require_once __DIR__.'/../vendor/autoload.php';

use Depot\Api\Client;

if (count($argv) < 2) {
    echo "Usage: check-profile-anonymous-by-endpoint.php [api_endpoint]\n";
    exit;
}

$apiEndpoint = $argv['1'];

$clientFactory = new Client\ClientFactory;
$client = $clientFactory->create();

$server = new Depot\Core\Model\Server\ApiEndpointsServer($apiEndpoint);

$profile = $client->profile()->getProfile($server);
$entity = new Depot\Core\Model\Entity\Entity($profile);

echo "Canonical Entity URI:\n";
echo $entity->uri()."\n";
echo "\n";

echo "Available Profile Info Types:\n";
print_r($entity->profileInfoTypes());
echo "\n";

$coreProfileInfo = $entity->findProfileInfo(
    'https://tent.io/types/info/core/v0.1.0'
);

echo "Core Profile Info:\n";
print_r($coreProfileInfo->content());
echo "\n";

$basicProfileInfo = $entity->findProfileInfo(
    'https://tent.io/types/info/basic/v0.1.0'
);

echo "Basic Profile Info:\n";
print_r($basicProfileInfo->content());
echo "\n";
