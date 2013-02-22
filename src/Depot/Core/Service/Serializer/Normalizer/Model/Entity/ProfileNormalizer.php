<?php

namespace Depot\Core\Service\Serializer\Normalizer\Model\Entity;

use Depot\Core\Model;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

class ProfileNormalizer extends SerializerAwareNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $data = array();
        foreach ($object->types() as $type) {
            $data[$type] = $this->serializer->normalize(
                $object->find($type),
                $format,
                $context
            );
        }

        return $data;
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $profile = new Model\Entity\Profile;
        foreach ($data as $uri => $content) {
            $profile->set($this->serializer->denormalize(
                $content,
                'Depot\Core\Model\Entity\ProfileInfoInterface',
                $format,
                array_merge($context, array(
                    'depot.profile_type.uri' => $uri,
                ))
            ));
        }

        return $profile;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Model\Entity\ProfileInterface;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return 'Depot\Core\Model\Entity\ProfileInterface' === $type;
    }
}
