<?php

namespace Ask\http\response\generic;

class Response
{
    public function __construct(int $status_code, string $mime_type = null, string $charset = '')
    {
        $status_code === 200 ?: http_response_code($status_code);
        is_null($mime_type) ?: header(
            'Content-Type: ' . $mime_type . ($charset ? '; charset=' . $charset : $charset)
        );
    }
}