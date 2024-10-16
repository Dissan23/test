<?php

function autoloaderFunction(string $class): void
{
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    } else {
        die("Файл для класса $class не найден.");
    }
}

spl_autoload_register('autoloaderFunction');


