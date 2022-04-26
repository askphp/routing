<?php

namespace Ask\general;

class Scope
{
    public static float $micro_time;
    public static string $project_path, $default_language, $request_uri, $php_url_path;

    public function __construct(float $micro_time, string $project_path, string $default_language)
    {
        self::$micro_time = $micro_time;
        self::$project_path = realpath($project_path) . DIRECTORY_SEPARATOR;
        self::$default_language = $default_language;
        self::$request_uri = urldecode($_SERVER['REQUEST_URI']);
        self::$php_url_path = parse_url(self::$request_uri, PHP_URL_PATH);
    }
}