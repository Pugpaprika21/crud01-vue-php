<?php

class Autoloader
{
    private static $folder_name = '//';

    public static function register()
    {
        spl_autoload_register(function ($class_name) {
            $class_path = str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
            $full_path = $_SERVER['DOCUMENT_ROOT'] . self::$folder_name . $class_path;

            if (file_exists($full_path)) require_once $full_path; return;
            http_response_code(404);
        });
    }
}

Autoloader::register();
