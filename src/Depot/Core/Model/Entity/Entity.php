<?php

namespace Depot\Core\Model\Entity;

class Entity implements EntityInterface
{
    protected $profile;
    protected $uri;

    public function __construct(ProfileInterface $profile)
    {
        $this->profile = $profile;
        $this->uri = $profile->findCoreEntityUri();
    }

    public function uri()
    {
        return $this->uri;
    }

    public function profileInfoTypes()
    {
        return $this->profile->types();
    }

    public function setProfileInfo(ProfileInfoInterface $profileInfo)
    {
        $this->profile->set($profileInfo);

        if (ProfileInterface::TYPE_CORE === $profileInfo->uri()) {
            $this->uri = $profile->findCoreEntityUri();
        }
    }

    public function findProfileInfo($uri)
    {
        return $this->profile->find($uri);
    }

    public function removeProfileInfo($uri)
    {
        $this->profile->remove($uri);
    }
}
