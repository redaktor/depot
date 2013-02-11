<?php

namespace Depot\Core\Service\Serializer;

interface SerializerInterface
{
    public function serialize($data, array $context = array());
    public function deserialize($data, $type, array $context = array());
}
