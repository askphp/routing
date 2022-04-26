<?php

namespace Ask\http\response;

class HtmlResponse extends generic\Response
{
    public function __construct(string $string, int $status_code = null, string $charset = null)
    {
        $args = is_null($charset) ? array() : array('text/html', $charset);
        parent::__construct($status_code ?? 200, ...$args);
        echo $string;
    }
}