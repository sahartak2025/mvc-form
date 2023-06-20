<?php

spl_autoload_register(function($className) {
    $file = $className . '.php';
    $file = '../' . str_ireplace('\\', '/', $file);
    if (file_exists($file)) {
        include $file;
    }
});