<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-12-18
 * Time: 19:23
 */

// ?str=여러분&pstr=여러분
define('DEBUG', false);
define('APP_PATH', __DIR__);

spl_autoload_register(function ($className) {
    include filePath($className . '.php');
});

function concatDirectories()
{
    $dirs = [];
    foreach (func_get_args() as $arg) {
        $dirs[] = rtrim($arg, '/\\');
    }
    return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, $dirs));
}

function fontPath($name)
{
    return concatDirectories(APP_PATH, 'fonts', $name . '.ttf');
}

function filePath($name)
{
    return concatDirectories(APP_PATH, $name);
}

use App\Application;

Application::getInstance()->run();