<?php

namespace Ask\routing;

use Ask\general\Scope;
use Ask\http\request\{primary\Url, Url as UrlArgs};

class Router extends Route
{
    private array $args;

    protected function newClass(array $route): void
    {
        if ($class = $this->class($route)) {
            new $class(...$this->args);
        } else {
            new Error(404);
        }
    }

    private function class(array $route): string
    {
        if ($this->routeInit($route)) {
            $this->args = $route[$this->route['url']];
            $class = array_shift($this->args);
            if ($this->exists(explode('\\', $class))) {
                $this->args($this->route['args']);
                return $class;
            }
        }
        return '';
    }

    private function exists(array $class): bool
    {
        $check_route = function () use ($class): bool {
            list($dir_name, $class_name) = array_slice($class, -2);
            return $class[1] === 'route' and ucfirst($dir_name) === $class_name;
        };

        $file_exists = function () use ($class): bool {
            return file_exists(Scope::$project_path . implode(
                    DIRECTORY_SEPARATOR, array_slice($class, 1)
                ) . '.php');
        };

        return $check_route and $file_exists;
    }

    private function args(array $args): void
    {
        if ($args) {
            $this->args = array(new UrlArgs($args), ...$this->args);
        } else {
            $this->args = array(new Url, ...$this->args);
        }
    }
}