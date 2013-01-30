<?php

namespace Depot\Core\Model\Post;

class Post implements PostInterface
{
    protected $entityUri;
    protected $id;
    protected $type;
    protected $licenses;
    protected $permissions;
    protected $content;
    protected $version;
    protected $app;
    protected $mentions;
    protected $publishedAt;
    protected $updatedAt;
    protected $receivedAt;

    public function __construct($entityUri, $id, $type, $licenses, $permissions, $content, $version, $app, $mentions, $publishedAt, $updatedAt, $receivedAt)
    {
        $this->entityUri = $entityUri;
        $this->id = $id;
        $this->type = $type;
        $this->licenses = $licenses;
        $this->permissions = $permissions;
        $this->content = $content;
        $this->version = $version;
        $this->app = $app;
        $this->mentions = $mentions;
        $this->publishedAt = $publishedAt;
        $this->updatedAt = $updatedAt;
        $this->receivedAt = $receivedAt;
    }

    public function entityUri()
    {
        return $this->entityUri;
    }

    public function id()
    {
        return $this->id;
    }

    public function type()
    {
        return $this->type;
    }

    public function licenses()
    {
        return $this->licenses;
    }

    public function permissions()
    {
        return $this->permissions;
    }

    public function content()
    {
        return $this->content;
    }

    public function version()
    {
        return $this->version;
    }

    public function app()
    {
        return $this->app;
    }

    public function mentions()
    {
        return $this->mentions;
    }

    public function publishedAt()
    {
        return $this->publishedAt;
    }

    public function updatedAt()
    {
        return $this->updatedAt;
    }

    public function receivedAt()
    {
        return $this->receivedAt;
    }
}
