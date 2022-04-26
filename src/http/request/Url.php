<?php

namespace Ask\http\request;

use stdClass;

class Url extends primary\Url
{
    public stdClass $args;

    public function __construct(array $args)
    {
        parent::__construct();
        $this->setArgs($args);
    }

    private function setArgs(array $args): void
    {
        $this->args = (object)$args;
    }
}