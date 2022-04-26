<?php

namespace Ask\http\request\primary;

use Ask\general\{Regex, Scope};

class Url
{
    public string $path;

    public function __construct()
    {
        $this->path = Scope::$php_url_path;
    }

    public function get(string $name, ...$args): string
    {
        return Regex::getUrl($name, ...$args);
    }
}