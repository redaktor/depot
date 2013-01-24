<?php

namespace Depot\Api\Client\HttpClient;

interface HttpResponseInterface
{
    public function headers();
    public function header($header);
    public function body();
}
