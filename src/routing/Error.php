<?php

namespace Ask\routing;

use Ask\general\{Regex, Scope};
use Ask\http\response\PlainResponse;

class Error
{
    public static array $class;

    public function __construct(int $status_code)
    {
        match ($status_code) {
            404 => $this->error404(self::$class[404]),
            500 => $this->error500(self::$class[500]),
            default => $this->default($status_code)
        };
    }

    private function error404(string $class): void
    {
        if ($class and !Regex::imageExtension(Scope::$php_url_path)) {
            new $class(404);
        } else {
            new PlainResponse('Not Found', 404);
        }
    }

    private function error500(string $class): void
    {
        if ($class) {
            new $class(500);
        } else {
            new PlainResponse('Internal Server Error', 500);
        }
    }

    private function default(int $status_code): void
    {
        new PlainResponse('Undeclared Error', $status_code);
    }
}