<?php

namespace Depot\Api\Client;

use Depot\Api\Client\Server;

class Client
{
    protected $discovery;

    public function __construct(Server\Discovery $discovery)
    {
        $this->discovery = $discovery;
    }

    public function discover($uri)
    {
        return $this->discovery->discover($uri);
    }
}
