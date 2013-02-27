<?php

namespace Depot\Core\Service\ServerApp;

use Depot\Core\Model;

interface ServerAppCreatorInterface
{
    public function create(Model\App\AppInterface $app);
}
