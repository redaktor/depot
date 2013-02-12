<?php

namespace Depot\Core\Service\Serializer;

use Symfony\Component\Serializer\Serializer as SymfonySerializerInterface;

class SymfonySerializer implements SerializerInterface
{
    protected $symfonySerializer;

    public function __construct(SymfonySerializerInterface $symfonySerializer)
    {
        $this->symfonySerializer = $symfonySerializer;
    }

    public function serialize($data, array $context = array())
    {
        return $this->symfonySerializer->serialize($data, 'json', $context);
    }

    public function deserialize($data, $type, array $context = array())
    {
        return $this->symfonySerializer->deserialize($data, $type, 'json', $context);
    }

    public function normalize($data, array $context = array())
    {
        return $this->symfonySerializer->normalize($data, 'json', $context);
    }

    public function denormalize($data, $type, array $context = array())
    {
        return $this->symfonySerializer->denormalize($data, $type, 'json', $context);
    }
}
