<?php

namespace Depot\Api\Common\Dto\App;

use Depot\Core\Model\App\ServerAppInterface;
use Depot\Core\Model\Auth\AuthInterface;

class AppCreationResponse
{
    protected $id;
    protected $app;
    protected $auth;
    protected $minimumAuthorizations;
    protected $createdAt;

    public function __construct($id, $app, AuthInterface $auth, array $minimumAuthorizations, $createdAt = null)
    {
        $this->id = $id;
        $this->app = $app;
        $this->auth = $auth;
        $this->minimumAuthorizations = $minimumAuthorizations;
        $this->createdAt = $createdAt;
    }

    public function id()
    {
        return $this->id;
    }

    public function app()
    {
        return $this->app;
    }

    public function auth()
    {
        return $this->auth;
    }

    public function minimumAuthorizations()
    {
        return $this->minimumAuthorizations;
    }

    public function createdAt()
    {
        return $this->createdAt;
    }

    public static function createFromServerApp(ServerAppInterface $serverApp)
    {
        return new AppCreationResponse(
            $serverApp->id(),
            $serverApp->app(),
            $serverApp->auth(),
            $serverApp->minimumAuthorizations(),
            $serverApp->createdAt()
        );
    }
}
