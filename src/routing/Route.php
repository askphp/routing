<?php

namespace Ask\routing;

use Ask\general\{Regex, Scope};

class Route
{
    protected array $route;
    private array $args, $part;

    protected function routeInit(array $route): bool
    {
        $this->args = array();
        foreach ($this->url($route) as $url) {
            $this->part = array();
            if (preg_match($this->pattern($url), Scope::$php_url_path, $matches)) {
                $this->route($url, $matches);
                return true;
            }
        }
        return false;
    }

    private function url($route): array
    {
        $temp = null;
        foreach ($route as $key => $value) {
            if (is_array($value)) {
                $temp = $key;
            } else {
                unset($route[$key]);
                Regex::$url_pattern[$value] = $temp;
            }
        }
        return array_keys($route);
    }

    private function pattern(string $url): string
    {
        $parse_part = function (string $part): string {
            $this_part = function (array $param): string {
                $this->part[] = array('type' => $param[0], 'name' => $param[1]);
                return Regex::$url_part[$param[0]];
            };

            if ($part === '') {
                $this->part[] = null;
                return $part;
            } elseif (str_starts_with($part, '{') and str_ends_with($part, '}')) {
                $string = substr($part, 1, -1);
                if (str_contains($string, ':')) {
                    $param = explode(':', $string);
                    if (count($param) === 2) {
                        if (array_key_exists($param[0], Regex::$url_part)) {
                            return $this_part($param);
                        }
                    }
                } else {
                    return $this_part(array('string', $string));
                }
            }
            return $part;
        };

        $part = explode('/', $url);
        for ($i = 0, $c = count($part) - 1, $parts = array(); $i <= $c; $i++) {
            $parts[$i] = $parse_part($part[$i]);
        }
        return '#^' . implode('/', $parts) . '$#i';
    }

    private function route(string $url, array $matches): void
    {
        $this_args = function (array $param, string $value): void {
            extract($param);
            $this->args[$name] = $type === 'float' ? (float)$value : (
            $type === 'int' ? (int)$value : $value
            );
        };

        for ($i = 0, $c = count($this->part) - 1; $i <= $c; $i++) {
            if ($this->part[$i]) {
                $this_args($this->part[$i], $matches[$i]);
            }
        }
        $this->route = array('url' => $url, 'args' => $this->args);
    }
}