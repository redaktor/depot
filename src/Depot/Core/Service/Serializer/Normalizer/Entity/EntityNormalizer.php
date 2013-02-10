<?php

namespace Depot\Core\Service\Serializer\Normalizer\Entity;

use Depot\Core\Model;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

class EntityNormalizer extends SerializerAwareNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $data = array();
        foreach ($object->profileInfoTypes() as $type) {
            $data[$type] = $this->serializer->normalize(
                $object->findProfileInfo($type),
                $format,
                $context
            );
        }

        return $data;
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $profile = $this->serializer->denormalize(
            $data,
            'Depot\Core\Model\Entity\ProfileInterface',
            $format,
            $context
        );

        return new Model\Entity\Entity($profile);
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Model\Entity\EntityInterface;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return 'Depot\Core\Model\Entity\EntityInterface' === $type;
    }
}
