<?php

namespace Depot\Api\Client;

use Depot\Api\Client\HttpClient\AuthenticatedHttpClient;
use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Api\Client\Server;
use Depot\Core\Model\Auth\AuthInterface;

class Client
{
    protected $clientFactory;
    protected $httpClient;
    protected $discovery;
    protected $profile;
    protected $apps;
    protected $posts;

    public function __construct(ClientFactory $clientFactory, HttpClientInterface $httpClient, Server\Discovery $discovery, Server\Profile $profile, Server\Apps $apps, Server\Posts $posts)
    {
        $this->clientFactory = $clientFactory;
        $this->httpClient = $httpClient;
        $this->discovery = $discovery;
        $this->profile = $profile;
        $this->apps = $apps;
        $this->posts = $posts;
    }

    public function discover($uri)
    {
        return $this->discovery->discover($uri);
    }

    public function profile()
    {
        return $this->profile;
    }

    public function apps()
    {
        return $this->apps;
    }

    public function posts()
    {
        return $this->posts;
    }

    public function authenticate(AuthInterface $auth)
    {
        $authenticatedHttpClient = new AuthenticatedHttpClient($this->httpClient, $auth);
        $authenticatedClient = $this->clientFactory->create($authenticatedHttpClient);

        return $authenticatedClient;
    }

    public function with(AuthInterface $auth, $callback)
    {
        $authenticatedClient = $this->authenticate($auth);

        call_user_func($callback, $authenticatedClient);
    }
}
