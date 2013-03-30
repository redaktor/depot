<?php
header("Content-Type: text/html; charset=utf-8");
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

if (count($argv) < 2) {
    echo "Usage: show-post-authenticated.php [id] [version]\n";
    exit;
}

$id = $argv[1];
$version = count($argv) > 2 ? $argv[2] : null;

$clientFactory = new Client\ClientFactory;
$client = $clientFactory->create();

$authFactory = new Auth\AuthFactory;
$auth = $authFactory->create($appConfig['authz_mac_key_id'], $appConfig['authz_mac_key']);

// Find the Server (Entity container)
$server = $client->discover($appConfig['entity_uri']);

$post = $client->authenticate($auth)->posts()->getPost($server, $id, $version);

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

