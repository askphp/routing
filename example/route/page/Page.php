<?php

namespace Example\route\page;

use Ask\general\Scope;
use Ask\http\request\Url;
use Ask\http\response\HtmlResponse;

class Page
{
    public function __construct(Url $url)
    {
        $string = '<p></p><a href="' . $url->get('index') . '">to main</a></p>' . PHP_EOL;
        $string .= 'Url-path ' . $url->path . '<br>' . PHP_EOL;
        $string .= 'path:page ' . $url->args->page . '<br>' . PHP_EOL;
        $string .= 'Timer: ' . round(microtime(true) - Scope::$micro_time, 3);
        new HtmlResponse($string);
    }
}