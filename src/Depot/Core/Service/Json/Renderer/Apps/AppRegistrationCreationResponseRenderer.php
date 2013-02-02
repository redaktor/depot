<?php

namespace Depot\Core\Service\Json\Renderer\Apps;

use Depot\Core\Model;
use Depot\Core\Service\Json\RendererInterface;

class AppRegistrationCreationResponseRenderer implements RendererInterface
{
    public function supports($object)
    {
        return $object instanceof Model\App\AppRegistrationCreationResponse;
    }

    public function renderToData($object)
    {
        if (!$object instanceof Model\App\AppRegistrationCreationResponse) {
            throw \InvalidArgumentException('Expected Model\App\AppRegistrationCreationResponse type');
        }

        $app = $object->app();
        $auth = $object->auth();

        return array(
            'id' => $object->id(),

            'name' => $app->name(),
            'description' => $app->description(),
            'url' => $app->url(),
            'icon' => $app->icon(),
            'redirect_uris' => $app->redirectUris(),
            'scopes' => $app->scopes(),

            'mac_key_id' => $auth->macKeyId(),
            'mac_key' => $auth->macKey(),
            'mac_algorithm' => $auth->macAlgorithm(),

            'authorizations' => $object->minimumAuthorizations(),
            'created_at' => $object->createdAt(),
        );
    }
}
