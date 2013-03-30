<?php
header("Content-Type: text/html; charset=utf-8");
require_once __DIR__.'/../../../autoload.php';

use Depot\Api\Client;

if (count($argv) < 3) {
    echo "Usage: show-post-anonymous.php [entity_uri] [id] [version]\n";
    exit;
}

$entityUri = $argv[1];
$id = $argv[2];
$version = count($argv) > 3 ? $argv[3] : null;

$clientFactory = new Client\ClientFactory;
$client = $clientFactory->create();

// Find the Server (Entity container)
$server = $client->discover($entityUri);

$post = $client->posts()->getPost($server, $id, $version);
$content = $post->content();

switch($post->type()) {
    case 'https://tent.io/types/post/status/v0.1.0':
        printf("\"\"\" ^%s: %s <post:%s>\n", $post->entityUri(), $content['text'], $post->id());
        break;
    case 'https://tent.io/types/post/follower/v0.1.0':
        printf(">>> ^%s was followed by ^%s <post:%s>\n", $post->entityUri(), $content['entity'], $post->id());
        break;
    case 'https://tent.io/types/post/repost/v0.1.0':
        printf("<-> ^%s reposted post %s originally posted by ^%s <post:%s>\n", $post->entityUri(), $content['id'], $content['entity'], $post->id());
        break;
    default:
        printf("<^%s> <%s> <post:%s>\n", $post->entityUri(), $post->type(), $post->id());
        print_r($content);
        break;
}

