<?php

namespace Depot\Core\Model\Entity;

interface EntityInterface
{
    public function uri();
    public function profileInfoTypes();
    public function setProfileInfo(ProfileInfoInterface $profileInfo);
    public function findProfileInfo($uri);
    public function removeProfileInfo($uri);
}
