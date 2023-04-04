<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\Controller\UserController;

$controller = new UserController();
$controller->registerUser($_POST);