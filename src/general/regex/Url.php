<?php

namespace Ask\general\regex;

class Url
{
    public static array $url_pattern, $url_part = array(
        'float' => '([0-9\.]{1,11})',
        'int' => '([0-9]{1,11})',
        'path' => '([a-zA-Z0-9/\.-]{1,255})',
        'string' => '([a-zA-Z0-9\.-]{1,255})',
    );

    public static function getUrl(string $name, ...$args): string
    {
        $url = self::$url_pattern[$name];
        if ($url === '/') {
            return $url;
        } else {
            $name = implode('/', array('', $name, ...$args));
            if (preg_match(self::pattern($url), $name)) {
                return $name;
            }
            return 'Url args error';
        }
    }

    private static function pattern(string $url): string
    {
        $part = explode('/', $url);
        for ($i = 0, $parts = array(), $c = count($part) - 1; $i <= $c; $i++) {
            $parts[$i] = self::parse($part[$i]);
        }
        return '#^' . implode('/', $parts) . '$#i';
    }

    private static function parse(string $part): string
    {
        if ($part === '') {
            return $part;
        } elseif (str_starts_with($part, '{') and str_ends_with($part, '}')) {
            $string = substr($part, 1, -1);
            if (str_contains($string, ':')) {
                $param = explode(':', $string);
                if (count($param) === 2) {
                    if (array_key_exists($param[0], self::$url_part)) {
                        return self::$url_part[$param[0]];
                    }
                }
            } else {
                return self::$url_part['string'];
            }
        }
        return $part;
    }
}