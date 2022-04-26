<?php

namespace Example\route\index;

use Ask\general\Scope;
use Ask\http\request\primary\Url;
use Ask\http\response\HtmlResponse;

class Index
{
    public function __construct(Url $url)
    {
        list($search, $replace) = $this->listSearchReplace(array(
            'page.example' => $url->get('page', 'path', 'example.html'),
            'response.html' => $url->get('response', 'html'),
            'response.json' => $url->get('response', 'json'),
            'response.plain' => $url->get('response', 'plain'),
            'response.error' => $url->get('response', 'error'),
            'error.html' => '/error.html',
            'error.ico' => '/error.ico',
            'url.get.null' => $url->get('response', 'error', 'null'),
            'timer' => 'Timer: ' . round(microtime(true) - Scope::$micro_time, 3),
        ));
        new HtmlResponse(str_replace(
            $search, $replace, file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'index.html')
        ));
    }

    private function listSearchReplace(array $context): array
    {
        return array(array_map(function ($key) {
            return '{{ ' . $key . ' }}';
        }, array_keys($context)), array_values($context));
    }
}