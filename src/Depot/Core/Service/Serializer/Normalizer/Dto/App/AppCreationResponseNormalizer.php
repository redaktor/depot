<?php

namespace Depot\Core\Service\Serializer\Normalizer\Dto\App;

use Depot\Api\Common\Dto;
use Depot\Core\Model;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

class AppCreationResponseNormalizer extends SerializerAwareNormalizer implements NormalizerInterface, DenormalizerInterface
{
    protected $authFactory;

    public function __construct(Model\Auth\AuthFactory $authFactory = null)
    {
        $this->authFactory = $authFactory ?: new Model\Auth\AuthFactory;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        $auth = $object->auth();

        return array_merge(
            $this->serializer->normalize($object->app(), $format, $context),
            array(
                'id' => $object->id(),

                'mac_key_id' => $auth->macKeyId(),
                'mac_key' => $auth->macKey(),
                'mac_algorithm' => $auth->macAlgorithm(),

                'authorizations' => $object->minimumAuthorizations(),
                'created_at' => $object->createdAt(),
            )
        );
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $app = $this->serializer->denormalize(
            $data,
            'Depot\Core\Model\App\AppInterface',
            $format,
            $context
        );

        $auth = $this->authFactory->create(
            $data['mac_key_id'],
            $data['mac_key'],
            $data['mac_algorithm']
        );

        return new Dto\App\AppCreationResponse(
            $data['id'],
            $app,
            $auth,
            $data['authorizations'],
            $data['created_at']
        );
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Dto\App\AppCreationResponse;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return 'Depot\Api\Common\Dto\App\AppCreationResponse' === $type;
    }
}
