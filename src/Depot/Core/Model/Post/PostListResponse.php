<?php

namespace Depot\Core\Model\Post;

class PostListResponse
{
    protected $posts;
    protected $previousCriteria;
    protected $nextCriteria;

    public function __construct(array $posts = array())
    {
        $this->posts = $posts;
    }

    public function posts()
    {
        return $this->posts;
    }

    public function previousCriteria()
    {
        return $this->previousCriteria;
    }

    public function setPreviousCriteria(PostCriteria $previousCriteria)
    {
        $this->previousCriteria = $previousCriteria;

        return $this;
    }

    public function nextCriteria()
    {
        return $this->nextCriteria;
    }

    public function setNextCriteria(PostCriteria $nextCriteria)
    {
        $this->nextCriteria = $nextCriteria;

        return $this;
    }
}
