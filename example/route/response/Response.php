<?php

namespace Example\route\response;

use Ask\general\Scope;
use Ask\http\request\Url;
use Ask\http\response\{
    HtmlResponse, JsonResponse, PlainResponse
};
use Example\Error;

class Response
{
    public function __construct(Url $url)
    {
        match ($url->args->response) {
            'html' => $this->html($url),
            'json' => $this->json($url),
            'plain' => $this->plain($url),
            default => new Error(404)
        };
    }

    private function html(Url $url): void
    {
        $string = 'Url-path ' . $url->path . '<br>' . PHP_EOL;
        $string .= 'string:response ' . $url->args->response . '<br>' . PHP_EOL;
        $string .= 'Timer ' . round(microtime(true) - Scope::$micro_time, 3);
        new HtmlResponse($string);
    }

    private function json(Url $url): void
    {
        new JsonResponse(array(
            'Url-path' => $url->path,
            'string:response' => $url->args->response,
            'Timer' => round(microtime(true) - Scope::$micro_time, 3),
        ));
    }

    private function plain(Url $url): void
    {
        $string = 'Url-path ' . $url->path . PHP_EOL;
        $string .= 'string:response ' . $url->args->response . PHP_EOL;
        $string .= 'Timer ' . round(microtime(true) - Scope::$micro_time, 3);
        new PlainResponse($string);
    }
}