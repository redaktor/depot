<?php

namespace Depot\Core\Domain\Model\App;

interface AppInterface
{
    public function name();
    public function description();
    public function url();
    public function icon();
    public function redirectUris();
    public function scopes();
}
