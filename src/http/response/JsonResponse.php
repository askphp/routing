<?php

namespace Ask\http\response;

class JsonResponse extends generic\Response
{
    public function __construct(array $data, int $status_code = null)
    {
        $json = json_encode($data);
        if ($json === false) $json = json_encode(['jsonError' => json_last_error_msg()]);
        if ($json === false) {
            $status_code = 500;
            $json = '{"jsonError":"Unknown error"}';
        }
        parent::__construct($status_code ?? 200, 'application/json');
        echo $json;
    }
}