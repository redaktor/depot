<?php

namespace Depot\Core\Service\Serializer;

use Depot\Core\Model;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class SerializerFactory
{
    protected $authFactory;

    public function __construct(Model\Auth\AuthFactory $authFactory = null)
    {
        $this->authFactory = $authFactory;
    }

    public function create()
    {
        return new Serializer(array(
            new Normalizer\Apps\AppNormalizer,
            new Normalizer\Apps\AppRegistrationCreationResponseNormalizer($this->authFactory),
            new Normalizer\Apps\AppRegistrationResponseNormalizer,
            new Normalizer\Entity\EntityNormalizer,
            new Normalizer\Entity\ProfileInfoNormalizer,
            new Normalizer\Entity\ProfileNormalizer,
        ), array(
            'json' => new JsonEncoder,
        ));
    }
}
