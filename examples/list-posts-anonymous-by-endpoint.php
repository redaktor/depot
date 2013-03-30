<?php
header("Content-Type: text/html; charset=utf-8");
require_once __DIR__.'/../vendor/autoload.php';

use Depot\Api\Client;

if (count($argv) < 2) {
    echo "Usage: list-posts-anonymous-by-endpoint.php [api_endpoint] [types<all>]\n";
    exit;
}

$apiEndpoint = $argv[1];
$postTypes = isset($argv[2]) ? explode(',', $argv[2]) : null;

$clientFactory = new Client\ClientFactory;
$client = $clientFactory->create();

$server = new Depot\Core\Model\Server\ApiEndpointsServer($apiEndpoint);

$postListResponse = null;

for ($i = 0; $i < 5; $i++ ) {
    if ($postListResponse) {
        if ($postCriteria = $postListResponse->nextCriteria()) {
            // If we have next criteria specified, use it!
            $postListResponse = $client->posts()->getPosts($server, $postCriteria);
        } else {
            // Otherwise we are done here.
            break;
        }
    } else {
        $postCriteria = new Depot\Core\Model\Post\PostCriteria;
        $postCriteria->limit = 5;
        if ($postTypes) {
            $postCriteria->postTypes = $postTypes;
        }
        $postListResponse = $client->posts()->getPosts($server, $postCriteria);
    }

    foreach ($postListResponse->posts() as $post) {
        $content = $post->content();
        switch($post->type()) {
            case 'https://tent.io/types/post/status/v0.1.0':
                printf("\"\"\" ^%s: %s <post:%s>\n", $post->entityUri(), utf8_decode($content['text']), $post->id());
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
    }
}

