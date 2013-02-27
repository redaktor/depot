<?php

namespace Depot\Core\Model;

interface SessionInterface
{
    public function persist($object);
    public function remove($object);
    public function merge($object);
    public function clear($objectName = null);
    public function detach($object);
    public function refresh($object);
    public function flush();
    public function transactional($func);
}
