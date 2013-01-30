<?php

namespace Depot\Core\Domain\Model\Post;

interface PostInterface
{
    public function entityUri();
    public function id();
    public function type();
    public function licenses();
    public function permissions();
    public function content();
    public function version();
    public function app();
    public function mentions();
    public function publishedAt();
    public function updatedAt();
    public function receivedAt();
}
