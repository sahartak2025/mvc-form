<?php

require 'autoload.php';

session_start();

define('ROOT_PATH', str_replace('public', '', $_SERVER['DOCUMENT_ROOT'] ));

(new \app\routing\Router())->runAction();