<?php

namespace Depot\Api\Server\Symfony\Controller\Apps;

use Depot\Core\Model;

class GetAppController
{
    protected $serverAppRepository;

    public function __construct(Model\App\ServerAppRepository $serverAppRepository)
    {
        $this->serverAppRepository = $serverAppRepository;
    }

    public function action($id)
    {
        return $this->serverAppRepository->find($id);
    }
}
