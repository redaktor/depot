<?php

namespace Depot\Core\Domain\Model\App;

use Depot\Core\Domain\Model;

class AppFactory
{
    public function createFromJsonString($jsonString)
    {
        $json = json_decode($jsonString, true);

        return new Model\App\App(
            $json['name'],
            $json['description'],
            $json['url'],
            $json['icon'],
            $json['redirect_uris'],
            $json['scopes']
        );
    }
}
