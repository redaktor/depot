<?php

namespace Depot\Core\Service\Serializer\Normalizer\Apps;

use Depot\Core\Model;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

class AppRegistrationResponseNormalizer extends SerializerAwareNormalizer implements NormalizerInterface, DenormalizerInterface
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

        return new Model\App\AppRegistrationResponse(
            $data['id'],
            $app,
            $data['authorizations'],
            $data['created_at']
        );
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Model\App\AppRegistrationResponse;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return 'Depot\Core\Model\App\AppRegistrationResponse' === $type;
    }
}
