<?php

namespace Depot\Core\Service\Serializer\Normalizer\Apps;

use Depot\Core\Model;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

class AppNormalizer extends SerializerAwareNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        return array(
            'name' => $object->name(),
            'description' => $object->description(),
            'url' => $object->url(),
            'icon' => $object->icon(),
            'redirect_uris' => $object->redirectUris(),
            'scopes' => $object->scopes(),
        );
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        return new Model\App\App(
            $data['name'],
            $data['description'],
            $data['url'],
            $data['icon'],
            $data['redirect_uris'],
            $data['scopes']
        );
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Model\App\AppInterface;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return 'Depot\Core\Model\App\AppInterface' === $type;
    }
}
