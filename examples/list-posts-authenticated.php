<?php

require_once __DIR__.'/../vendor/autoload.php';

use Depot\Api\Client;
use Depot\Core\Domain\Model\Auth;

if (count($argv) < 2) {
    echo "Usage: list-posts-anonymous.php [entity_uri] [types<all>]\n";
    exit;
}

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

$entityUri = $argv[1];
$postTypes = isset($argv[2]) ? explode(',', $argv[2]) : null;

// Create the client.
$client = Client\ClientFactory::create();

$authFactory = new Auth\AuthFactory;
$auth = $authFactory->create($appConfig['app_mac_key_id'], $appConfig['app_mac_key']);

// Find the Server (Entity container)
$server = $client->discover($entityUri);

$postListResponse = null;

for ($i = 0; $i < 5; $i++ ) {
    if ($postListResponse) {
        if ($postCriteria = $postListResponse->nextCriteria()) {
            // If we have next criteria specified, use it!
            $postListResponse = $client->authenticate($auth)->post()->getPosts($server, $postCriteria);
        } else {
            // Otherwise we are done here.
            break;
        }
    } else {
        $postCriteria = new Depot\Core\Domain\Model\Post\PostCriteria;
        $postCriteria->limit = 5;
        if ($postTypes) {
            $postCriteria->postTypes = $postTypes;
        }
        $postListResponse = $client->authenticate($auth)->post()->getPosts($server, $postCriteria);
    }

    foreach ($postListResponse->posts() as $post) {
        $content = $post->content();
        switch($post->type()) {
            case 'https://tent.io/types/post/status/v0.1.0':
                printf("\"\"\" ^%s: %s\n", $post->entityUri(), $content['text']);
                break;
            case 'https://tent.io/types/post/follower/v0.1.0':
                printf(">>> ^%s was followed by ^%s\n", $post->entityUri(), $content['entity']);
                break;
            case 'https://tent.io/types/post/repost/v0.1.0':
                printf("<-> ^%s reposted post %s originally posted by ^%s\n", $post->entityUri(), $content['id'], $content['entity']);
                break;
            default:
                printf("<^%s> <%s>\n", $post->entityUri(), $post->type());
                print_r($content);
                break;
        }
    }
}

