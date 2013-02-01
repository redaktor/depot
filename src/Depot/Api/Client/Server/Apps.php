<?php

namespace Depot\Api\Client\Server;

use Depot\Api\Client\HttpClient\AuthenticatedHttpClient;
use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Api\Client\HttpClient\TentHttpClient;
use Depot\Core\Model;
use Depot\Core\Service\Random\RandomInterface;

class Apps
{
    protected $rawHttpClient;
    protected $httpClient;
    protected $authFactory;
    protected $random;

    public function __construct(HttpClientInterface $httpClient, Model\Auth\AuthFactory $authFactory, RandomInterface $random)
    {
        $this->httpClient = $httpClient;
        $this->tentHttpClient = new TentHttpClient($httpClient);
        $this->authFactory = $authFactory;
        $this->random = $random;
    }

    public function register(Model\Server\ServerInterface $server, Model\App\AppInterface $app)
    {
        return ServerHelper::tryAllServers($server, array($this, 'registerInternal'), array($app));
    }

    public function generateClientAuthorizationRequest(Model\Server\ServerInterface $server, Model\App\ClientAppInterface $clientApp, $redirectUri, $scopes, $profileTypes, $postTypes)
    {
        list ($apiRoot) = $server->servers();

        $state  = $this->random->generateUrlSafeBase64(32);

        $params = array(
            'client_id' => $clientApp->id(),
            'redirect_uri' => $redirectUri,
            'scope' => implode(',', $scopes),
            'state' => $state,
            'tent_profile_info_types' => implode(',', $profileTypes),
            'tent_post_types' => implode(',', $postTypes),
        );

        return new Model\App\ClientAuthorizationRequest(
            $clientApp,
            $state,
            $apiRoot.'/oauth/authorize?'.http_build_query($params)
        );
    }

    public function exchangeCode(Model\Server\ServerInterface $server, Model\App\ClientAppInterface $clientApp, $code)
    {
        list ($apiRoot) = $server->servers();

        $payload = array(
            'code' => $code,
            'token_type' => 'mac',
        );

        $response = $this->tentHttpClient->post(
            $apiRoot.'/apps/'.$clientApp->id().'/authorizations',
            null,
            json_encode($payload)
        )->send();

        $json = json_decode($response->getBody(), true);

        return new Model\App\ClientAuthorizationResponse(
            $clientApp,
            $this->authFactory->create(
                $json['access_token'],
                $json['mac_key'],
                $json['mac_algorithm']
            ),
            $json['token_type'],
            $json['refresh_token'],
            isset($json['tent_expires_at']) ? $json['tent_expires_at'] : null
        );
    }

    public function getApps(Model\Server\ServerInterface $server, Model\App\ClientAppInterface $clientApp)
    {
        return ServerHelper::tryAllServers($server, array($this, 'getAppsInternal'), array($clientApp));
    }

    public function putApps(Model\Server\ServerInterface $server, Model\App\ClientAppInterface $clientApp)
    {
        return ServerHelper::tryAllServers($server, array($this, 'putAppsInternal'), array($clientApp));
    }

    public function registerInternal(Model\Server\ServerInterface $server, $apiRoot, Model\App\AppInterface $app)
    {
        $payload = array(
            'name' => $app->name(),
            'description' => $app->description(),
            'url' => $app->url(),
            'icon' => $app->icon(),
            'redirect_uris' => $app->redirectUris(),
            'scopes' => $app->scopes(),
        );

        $response = $this->tentHttpClient->post($apiRoot.'/apps', null, json_encode($payload))->send();

        $json = json_decode($response->getBody(), true);

        $app = new Model\App\App(
            $json['name'],
            $json['description'],
            $json['url'],
            $json['icon'],
            $json['redirect_uris'],
            $json['scopes']
        );

        $auth = $this->authFactory->create(
            $json['mac_key_id'],
            $json['mac_key'],
            $json['mac_algorithm']
        );

        return new Model\App\AppRegistrationCreationResponse(
            $json['id'],
            $app,
            $auth,
            $json['authorizations'],
            $json['created_at']
        );
    }

    public function getAppsInternal(Model\Server\ServerInterface $server, $apiRoot, Model\App\ClientAppInterface $clientApp)
    {
        $response = $this->tentHttpClient->get($apiRoot.'/apps/'.$clientApp->id())->send();

        $json = json_decode($response->getBody(), true);

        $app = new Model\App\App(
            $json['name'],
            $json['description'],
            $json['url'],
            $json['icon'],
            $json['redirect_uris'],
            $json['scopes']
        );

        $clientApp->replaceApp($app);

        return new Model\App\AppRegistrationResponse(
            $json['id'],
            $app,
            $json['authorizations'],
            $json['created_at']
        );
    }

    public function putAppsInternal(Model\Server\ServerInterface $server, $apiRoot, Model\App\ClientAppInterface $clientApp)
    {
        $app = $clientApp->app();

        $payload = array(
            'name' => $app->name(),
            'description' => $app->description(),
            'url' => $app->url(),
            'icon' => $app->icon(),
            'redirect_uris' => $app->redirectUris(),
            'scopes' => $app->scopes(),
        );

        $response = $this->tentHttpClient->put($apiRoot.'/apps/'.$clientApp->id(), null, json_encode($payload))->send();

        $json = json_decode($response->getBody(), true);

        $app = new Model\App\App(
            $json['name'],
            $json['description'],
            $json['url'],
            $json['icon'],
            $json['redirect_uris'],
            $json['scopes']
        );

        $clientApp->replaceApp($app);

        return new Model\App\AppRegistrationResponse(
            $json['id'],
            $app,
            $json['authorizations'],
            $json['created_at']
        );
    }
}
