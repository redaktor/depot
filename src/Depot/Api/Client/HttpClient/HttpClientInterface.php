<?php

namespace Depot\Api\Client\HttpClient;

use Depot\Core\Model\Auth\AuthInterface;

interface HttpClientInterface
{
    public function head($uri);
    public function get($uri, $headers = null);
    public function post($uri, $headers = null, $payload = null);
    public function put($uri, $headers = null, $payload = null);
    public function delete($uri, $headers = null);
}
