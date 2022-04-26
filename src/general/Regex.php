<?php

namespace Ask\general;

class Regex extends regex\Url
{
    public static function imageExtension(string $string): bool
    {
        return preg_match('#\.(?:ico|png|jpg|jpeg|bmp|gif|tiff)$#i', $string);
    }
}