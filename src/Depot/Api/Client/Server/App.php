<?php

namespace Depot\Api\Client\Server;

use Depot\Api\Client\HttpClient\AuthenticatedHttpClient;
use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Core\Domain\Model;

class App
{
    protected $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function register(Model\Server\ServerInterface $server, Model\App\App $app)
    {
        return ServerHelper::tryAllServers($server, array($this, 'registerInternal'), array($app));
    }

    public function generateAuthorizationRequest(Model\Server\ServerInterface $server, Model\App\RegisteredAppAuthInterface $registeredAppAuth, $redirectUri, $scopes, $profileTypes, $postTypes)
    {
        list ($apiRoot) = $server->servers();

        $registeredApp = $registeredAppAuth->registeredApp();
        $auth = $registeredAppAuth->auth();

        $state  = str_replace(array('/', '+', '='), '', base64_encode(openssl_random_pseudo_bytes(64)));

        $params = array(
            'client_id' => $registeredApp->id(),
            'redirect_uri' => $redirectUri,
            'scope' => implode(',', $scopes),
            'state' => $state,
            'tent_profile_info_types' => implode(',', $profileTypes),
            'tent_post_types' => implode(',', $postTypes),
        );

        return new Model\App\AuthorizationRequest(
            $state,
            $apiRoot.'/oauth/authorize?'.http_build_query($params)
        );
    }

    public function exchangeCode(Model\Server\ServerInterface $server, Model\App\RegisteredAppAuthInterface $registeredAppAuth, $code)
    {
        list ($apiRoot) = $server->servers();

        $registeredApp = $registeredAppAuth->registeredApp();
        $auth = $registeredAppAuth->auth();

        $payload = array(
            'code' => $code,
            'token_type' => 'mac',
        );

        //$httpClient = new AuthenticatedHttpClient($this->httpClient, $auth);

        $response = $this->httpClient->post(
            $apiRoot.'/apps/'.$registeredApp->id().'/authorizations',
            null,
            json_encode($payload)
        );

        $json = json_decode($response->body(), true);

        print_r($json);

        return new Model\App\AuthorizationAuth(
            $registeredApp,
            Model\Auth\AuthFactory::create(
                $json['access_token'],
                $json['mac_key'],
                $json['mac_algorithm']
            ),
            $json['token_type'],
            $json['refresh_token'],
            isset($json['tent_expires_at']) ? $json['tent_expires_at'] : null
        );
    }

    public function registerInternal(Model\Server\ServerInterface $server, $apiRoot, Model\App\App $app)
    {
        $payload = array(
            'name' => $app->name(),
            'description' => $app->description(),
            'url' => $app->url(),
            'icon' => $app->icon(),
            'redirect_uris' => $app->redirectUris(),
            'scopes' => $app->scopes(),
        );

        $response = $this->httpClient->post($apiRoot.'/apps', null, json_encode($payload));

        $json = json_decode($response->body(), true);

        $registeredApp = new Model\App\RegisteredApp(
            $json['name'],
            $json['description'],
            $json['url'],
            $json['icon'],
            $json['redirect_uris'],
            $json['scopes'],
            $json['id'],
            $json['authorizations'],
            $json['created_at']
        );

        $auth = Model\Auth\AuthFactory::create(
            $json['mac_key_id'],
            $json['mac_key'],
            $json['mac_algorithm']
        );

        return new Model\App\RegisteredAppAuth($registeredApp, $auth);
    }
}
