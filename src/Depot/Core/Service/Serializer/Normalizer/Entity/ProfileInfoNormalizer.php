<?php

namespace Depot\Core\Service\Serializer\Normalizer\Entity;

use Depot\Core\Model;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

class ProfileInfoNormalizer extends SerializerAwareNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        return $object->content();
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        return new Model\Entity\ProfileInfo($context['depot.profile_type.uri'], $data);
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Model\Entity\ProfileInfoInterface;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return 'Depot\Core\Model\Entity\ProfileInfoInterface' === $type;
    }
}
