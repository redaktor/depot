<?php

namespace Depot\Core\Domain\Model\Post;

class PostCriteria
{
    public $sinceId;
    public $sinceIdEntity;
    public $beforeId;
    public $beforeIdEntity;
    public $untilId;
    public $untilIdEntity;
    public $sinceTime;
    public $beforeTime;
    public $sortBy;
    public $entity;
    public $mentionedEntity;
    public $postTypes;
    public $limit;
}
