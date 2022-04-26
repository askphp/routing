<?php

spl_autoload_register(function ($class) {
    require __DIR__ . '/' . str_replace('\\', '/', match (explode('\\', $class)[0]) {
                'Ask' => 'src' . substr($class, 3),
                default => lcfirst($class),
            } . '.php');
});