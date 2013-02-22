<?php

namespace Depot\Api\Common\Dto\App;

use Depot\Core\Model\App\ClientAppInterface;

class ClientAuthorizationRequest
{
    public $clientApp;
    public $state;
    public $url;

    public function __construct(ClientAppInterface $clientApp, $state, $url)
    {
        $this->clientApp = $clientApp;
        $this->state = $state;
        $this->url = $url;
    }

    public function clientApp()
    {
        return $this->clientApp;
    }

    public function state()
    {
        return $this->state;
    }

    public function url()
    {
        return $this->url;
    }
}
