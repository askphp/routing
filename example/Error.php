<?php

namespace Example;

use Ask\general\Scope;
use Ask\http\response\HtmlResponse;

class Error
{
    public function __construct(int $status_code)
    {
        $string = 'Error: ' . $status_code . '<br>' . PHP_EOL . 'Timer: ';
        $string .= round(microtime(true) - Scope::$micro_time, 3);
        new HtmlResponse($string, $status_code);
    }
}