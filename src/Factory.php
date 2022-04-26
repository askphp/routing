<?php

namespace Ask;

use Ask\routing\{Error, Router};

class Factory extends Router
{
    public function __construct(float $micro_time, string $project_path, string $default_language)
    {
        new general\Scope($micro_time, $project_path, $default_language);
    }

    public function run(array $error = null, array $route = null): void
    {
        $error = $error ?? array();
        Error::$class[404] = $error[404] ?? '';
        $this->newClass($route ?? array());
    }
}