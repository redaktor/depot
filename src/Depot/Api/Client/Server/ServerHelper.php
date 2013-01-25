<?php

namespace Depot\Api\Client\Server;

use Depot\Core\Domain\Model;

class ServerHelper
{
    public static function tryAllServers(Model\Server\ServerInterface $server, $callback, $additionalArgs = null)
    {
        foreach ($server->servers() as $target) {
            $args = array($server, $target);

            if (null !== $additionalArgs) {
                $args = array_merge($args, $additionalArgs);
            }

            return call_user_func_array($callback, $args);
        }

        throw new \RuntimeException("Unable to send to any server");
    }
}
