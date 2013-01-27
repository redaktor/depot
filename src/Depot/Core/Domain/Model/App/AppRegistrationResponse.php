<?php

namespace Depot\Core\Domain\Model\App;

class AppRegistrationResponse
{
    protected $id;
    protected $app;
    protected $minimumAuthorizations;
    protected $createdAt;

    public function __construct($id, $app, array $minimumAuthorizations, $createdAt = null)
    {
        $this->id = $id;
        $this->app = $app;
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
        return new AppRegistrationResponse(
            $serverApp->id(),
            $serverApp->app(),
            $serverApp->minimumAuthorizations(),
            $serverApp->createdAt()
        );
    }
}
