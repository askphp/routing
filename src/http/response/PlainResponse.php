<?php

namespace Ask\http\response;

class PlainResponse extends generic\Response
{
    public function __construct(string $string, int $status_code = null, string $charset = 'UTF-8')
    {
        parent::__construct($status_code ?? 200, 'text/plain', $charset);
        echo $string;
    }
}