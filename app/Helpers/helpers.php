<?php

use PayAny\Handlers\Response;

if (! function_exists('responseHandler')) {
    function responseHandler()
    {
        return app(Response::class);
    }
}

if (! function_exists('isDevelop')) {
    function isDevelop()
    {
        return (bool) in_array(env('APP_ENV'), ['develop', 'local', 'dev']);
    }
}
if (! function_exists('isTesting')) {
    function isTesting()
    {
        return (bool) in_array(env('APP_ENV'), ['test', 'testing']);
    }
}

if (! function_exists('showText')) {
    function showText(string $locale, string $arg = null, string $origin = 'responses')
    {
        $key = "{$origin}.{$locale}.{$arg}";
        $text = trans($key);
        return $key === $text
            ? trans("{$origin}.{$locale}.default")
            : $text;
    }
}
