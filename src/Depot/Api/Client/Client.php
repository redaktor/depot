<?php

namespace Depot\Api\Client;

use Depot\Api\Client\HttpClient\AuthenticatedHttpClient;
use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Api\Client\Server;
use Depot\Core\Domain\Model\Auth\AuthInterface;

class Client
{
    protected $discovery;
    protected $profile;

    public function __construct(HttpClientInterface $httpClient, Server\Discovery $discovery, Server\Profile $profile, Server\App $app)
    {
        $this->httpClient = $httpClient;
        $this->discovery = $discovery;
        $this->profile = $profile;
        $this->app = $app;
    }

    public function discover($uri)
    {
        return $this->discovery->discover($uri);
    }

    public function profile()
    {
        return $this->profile;
    }

    public function app()
    {
        return $this->app;
    }

    public function authenticate(AuthInterface $auth)
    {
        $authenticatedHttpClient = new AuthenticatedHttpClient($this->httpClient, $auth);
        $authenticatedClient = ClientFactory::create($authenticatedHttpClient);

        return $authenticatedClient;
    }

    public function with(AuthInterface $auth, $callback)
    {
        $authenticatedClient = $this->authenticate($auth);

        call_user_func($callback, $authenticatedClient);
    }
}
