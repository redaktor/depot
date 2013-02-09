<?php

namespace Depot\Api\Client\Server;

use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Api\Client\HttpClient\TentHttpClient;
use Depot\Core\Model;

class Profile
{
    protected $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->tentHttpClient = new TentHttpClient($httpClient);
    }

    public function getProfile(Model\Server\ServerInterface $server)
    {
        return ServerHelper::tryAllServers($server, array($this, 'getProfileInternal'));
    }

    public function getProfileInfo(Model\Server\ServerInterface $server, $type)
    {
        return ServerHelper::tryAllServers($server, array($this, 'getProfileInfoInternal'), array($type));
    }

    public function putProfileInfo(Model\Server\ServerInterface $server, Model\Entity\ProfileInfoInterface $profileInfo)
    {
        return ServerHelper::tryAllServers($server, array($this, 'putProfileInfoInternal'), array($profileInfo));
    }

    public function getProfileInternal(Model\Server\ServerInterface $server, $apiRoot)
    {
        $response = $this->tentHttpClient->get($apiRoot.'/profile')->send();

        $profile = static::createProfileFromJson(json_decode($response->getBody(), true));

        $newTypes = array();
        foreach ($profile->types() as $type) {
            $newTypes[$type] = true;
            if ($server instanceof Model\Server\EntityServer) {
                $server->entity()->profile()->set($profile->find($type));
            }
        }

        if ($server instanceof Model\Server\EntityServer) {
            foreach ($server->entity()->profile()->types() as $type) {
                if (! isset($newTypes[$type])) {
                    $server->entity()->profile()->remove($type);
                }
            }
        }

        return $profile;
    }

    public function getProfileInfoInternal(Model\Server\ServerInterface $server, $apiRoot, $type)
    {
        $response = $this->tentHttpClient->get($apiRoot.'/profile/'.rawurlencode($type));

        $profileInfo = new Model\Entity\ProfileInfo($type, json_decode($response->body(), true));

        if ($server instanceof Model\Server\EntityServer) {
            $server->entity()->profile()->set($profileInfo);
        }

        return $profileInfo;
    }

    public function putProfileInfoInternal(Model\Server\ServerInterface $server, $apiRoot, Model\Entity\ProfileInfoInterface $profileInfo)
    {
        $response = $this->tentHttpClient->put(
            $apiRoot.'/profile/'.rawurlencode($profileInfo->uri()),
            null,
            json_encode($profileInfo->content())
        );

        $profileInfo = new Model\Entity\ProfileInfo($profileInfo->uri(), json_decode($response->body(), true));

        if ($server instanceof Model\Server\EntityServer) {
            $server->entity()->profile()->set($profileInfo);
        }

        return $profileInfo;
    }

    public static function createProfileFromJson($json)
    {
        if ( ! isset($json['https://tent.io/types/info/core/v0.1.0']['entity'])) {
            return null;
        }

        if ( ! isset($json['https://tent.io/types/info/core/v0.1.0']['servers'])) {
            return null;
        }

        $profile = new Model\Entity\Profile;
        foreach ($json as $type => $content) {
            $profile->set(new Model\Entity\ProfileInfo($type, $content));
        }

        return $profile;
    }
}
