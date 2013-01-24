<?php

namespace Depot\Api\Client;

use Depot\Api\Client\Server;

class Client
{
    protected $discovery;
    protected $profile;

    public function __construct(Server\Discovery $discovery, Server\Profile $profile)
    {
        $this->discovery = $discovery;
        $this->profile = $profile;
    }

    public function discover($uri)
    {
        return $this->discovery->discover($uri);
    }

    public function profile()
    {
        return $this->profile;
    }
}
