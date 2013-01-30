<?php

namespace Depot\Core\Service\Json\Renderer\App;

use Depot\Core\Model;
use Depot\Core\Service\Json\RendererInterface;

class AppRegistrationCreationResponseRenderer implements RendererInterface
{
    public function supports($object)
    {
        return $object instanceof Model\App\AppRegistrationResponse;
    }

    public function renderToData($object)
    {
        if (!$object instanceof Model\App\AppRegistrationResponse) {
            throw \InvalidArgumentException('Expected Model\App\AppRegistrationResponse type');
        }

        $app = $object->app();

        return array(
            'id' => $object->id(),

            'name' => $app->name(),
            'description' => $app->description(),
            'url' => $app->url(),
            'icon' => $app->icon(),
            'redirect_uris' => $app->redirectUris(),
            'scopes' => $app->scopes(),

            'authorizations' => $object->minimumAuthorizations(),
            'created_at' => $object->createdAt(),
        );
    }
}
