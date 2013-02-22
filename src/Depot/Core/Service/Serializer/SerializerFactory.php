<?php

namespace Depot\Core\Service\Serializer;

use Depot\Core\Model;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer as SymfonySerializerImpl;

class SerializerFactory
{
    protected $authFactory;

    public function __construct(Model\Auth\AuthFactory $authFactory = null)
    {
        $this->authFactory = $authFactory;
    }

    public function create()
    {
        return new SymfonySerializer(new SymfonySerializerImpl(array(
            new Normalizer\Dto\App\AppCreationResponseNormalizer($this->authFactory),
            new Normalizer\Dto\App\AppResponseNormalizer,

            new Normalizer\Model\App\AppNormalizer,
            new Normalizer\Model\Entity\EntityNormalizer,
            new Normalizer\Model\Entity\ProfileInfoNormalizer,
            new Normalizer\Model\Entity\ProfileNormalizer,
        ), array(
            'json' => new JsonEncoder,
        )));
    }
}
