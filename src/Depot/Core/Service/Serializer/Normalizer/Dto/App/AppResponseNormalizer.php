<?php

namespace Depot\Core\Service\Serializer\Normalizer\Dto\App;

use Depot\Api\Common\Dto;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

class AppResponseNormalizer extends SerializerAwareNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        return array_merge(
            $this->serializer->normalize($object->app(), $format, $context),
            array(
                'id' => $object->id(),

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

        return new Dto\App\AppRegistrationResponse(
            $data['id'],
            $app,
            $data['authorizations'],
            $data['created_at']
        );
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Dto\App\AppRegistrationResponse;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return 'Depot\Api\Common\Dto\App\AppRegistrationResponse' === $type;
    }
}
