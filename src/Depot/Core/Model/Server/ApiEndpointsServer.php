<?php

namespace Depot\Core\Model\Server;

class ApiEndpointsServer implements ServerInterface
{
    private $servers = array();

    public function __construct($servers)
    {
        $this->servers = (array) $servers;
    }

    public function servers()
    {
        return $this->servers;
    }
}
