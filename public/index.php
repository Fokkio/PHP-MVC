<?php

declare(strict_types=1);
session_start();

const INCLUDES_DIR = __DIR__ . '/../includes';
const ROUTE_DIR = __DIR__ . '/../routes';
const TEMPLATES_DIR = __DIR__ . '/../templates';
const DATABASES_DIR = __DIR__ . '/../databases';
const DTO_DIR = __DIR__ . '/../DTOs';

require_once DATABASES_DIR . '/database.php';

require_once INCLUDES_DIR . '/router.php';
require_once INCLUDES_DIR . '/view.php';
require_once INCLUDES_DIR . '/helper.php';
require_once INCLUDES_DIR . '/bootstrap.php';

$connection = db_connect();

$userRepo = new UserRepository($connection);
$eventRepo = new EventRepository($connection);

require_once ROUTE_DIR . '/EventController.php';
require_once ROUTE_DIR . '/UserController.php';

const PUBLIC_ROUTES = ['', 'login','events','register'];
const ALLOW_METHODS = ['GET', 'POST'];

dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
