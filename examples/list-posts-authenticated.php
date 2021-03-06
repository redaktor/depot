<?php

require_once __DIR__.'/../../../autoload.php';

use Depot\Api\Client;
use Depot\Core\Model\Auth;

$appConfig = file_exists(__DIR__.'/.tent-credentials.json')
    ? json_decode(file_get_contents(__DIR__.'/.tent-credentials.json'), true)
    : $appConfig = array(
        'app_id' => 'XXXXXX',

        'app_mac_key_id' => 'a:YYYYYYY',
        'app_mac_key' => 'ABCDEF001122334455',

        'authz_mac_key_id' => 'u:AAA-BBB-CCC',
        'authz_mac_key' => '01AA02BB03CC04DD05',

        'entity_uri' => 'https://depot-testapp.tent.is',
    );

$postTypes = isset($argv[1]) ? explode(',', $argv[1]) : null;

$clientFactory = new Client\ClientFactory;
$client = $clientFactory->create();

$authFactory = new Auth\AuthFactory;
$auth = $authFactory->create($appConfig['authz_mac_key_id'], $appConfig['authz_mac_key']);

// Find the Server (Entity container)
$server = $client->discover($appConfig['entity_uri']);

$postListResponse = null;

for ($i = 0; $i < 5; $i++ ) {
    if ($postListResponse) {
        if ($postCriteria = $postListResponse->nextCriteria()) {
            // If we have next criteria specified, use it!
            $postListResponse = $client->authenticate($auth)->posts()->getPosts($server, $postCriteria);
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
        $postListResponse = $client->authenticate($auth)->posts()->getPosts($server, $postCriteria);
    }

    foreach ($postListResponse->posts() as $post) {
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
    }
}

