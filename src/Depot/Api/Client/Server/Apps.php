<?php

namespace Depot\Api\Client\Server;

use Depot\Api\Client\HttpClient\AuthenticatedHttpClient;
use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Api\Client\HttpClient\TentHttpClient;
use Depot\Core\Model;
use Depot\Core\Service\Random\RandomInterface;
use Depot\Core\Service\Serializer\SerializerInterface;

class Apps
{
    protected $serializer;
    protected $rawHttpClient;
    protected $httpClient;
    protected $authFactory;
    protected $random;

    public function __construct(SerializerInterface $serializer, HttpClientInterface $httpClient, Model\Auth\AuthFactory $authFactory, RandomInterface $random)
    {
        $this->serializer = $serializer;
        $this->httpClient = $httpClient;
        $this->tentHttpClient = new TentHttpClient($httpClient);
        $this->authFactory = $authFactory;
        $this->random = $random;
    }

    public function register(Model\Server\ServerInterface $server, Model\App\AppInterface $app)
    {
        return ServerHelper::tryAllServers($server, array($this, 'registerInternal'), array($app));
    }

    public function generateClientAuthorizationRequest(Model\Server\ServerInterface $server, Model\App\ClientAppInterface $clientApp, $redirectUri, $scopes, $profileInfoTypes, $postTypes)
    {
        list ($apiRoot) = $server->servers();

        $state  = $this->random->generateUrlSafeBase64(32);

        $params = array(
            'client_id' => $clientApp->id(),
            'redirect_uri' => $redirectUri,
            'scope' => implode(',', $scopes),
            'state' => $state,
            'tent_profile_info_types' => implode(',', $profileInfoTypes),
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
        $payload = $this->serializer->serialize($app);

        $response = $this->tentHttpClient->post($apiRoot.'/apps', null, $payload)->send();

        return $this->serializer->deserialize(
            $response->getBody(),
            'Depot\Core\Model\App\AppRegistrationCreationResponse'
        );
    }

    public function getAppsInternal(Model\Server\ServerInterface $server, $apiRoot, Model\App\ClientAppInterface $clientApp)
    {
        $response = $this->tentHttpClient->get($apiRoot.'/apps/'.$clientApp->id())->send();

        $appRegistrationResponse = $this->serializer->deserialize(
            $response->getBody(),
            'Depot\Core\Model\App\AppRegistrationResponse'
        );

        $clientApp->replaceApp($appRegistrationResponse->app());

        return $appRegistrationResponse;
    }

    public function putAppsInternal(Model\Server\ServerInterface $server, $apiRoot, Model\App\ClientAppInterface $clientApp)
    {
        $app = $clientApp->app();

        $payload = $this->serializer->serialize($app);

        $response = $this->tentHttpClient->put($apiRoot.'/apps/'.$clientApp->id(), null, $payload)->send();

        $appRegistrationResponse = $this->serializer->deserialize(
            $response->getBody(),
            'Depot\Core\Model\App\AppRegistrationResponse'
        );

        $clientApp->replaceApp($appRegistrationResponse->app());

        return $appRegistrationResponse;
    }
}
