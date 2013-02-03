<?php

namespace Depot\Core\Model\Entity;

class ProfileInfo implements ProfileInfoInterface
{
    protected $uri;

    public function __construct($uri, $content)
    {
        $this->uri = $uri;
        $this->content = $content;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function content()
    {
        return $this->content;
    }
}
