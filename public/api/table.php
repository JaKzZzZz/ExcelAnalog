<?php

namespace Jakzz\ExcelAnalog\Api;

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('PROJECT_ROOT', dirname(__DIR__, 2));

require_once __DIR__ . '/../../vendor/autoload.php';

use Jakzz\ExcelAnalog\Controllers\TableController;
use Jakzz\ExcelAnalog\Repositories\JsonTableRepository;


$repository = new JsonTableRepository(
    PROJECT_ROOT . "/storage/data.json"
);

$controller = new TableController($repository);

switch ($_SERVER["REQUEST_METHOD"]) {

    case "GET":
        $controller->load();
        break;

    case "POST":
        $controller->save();
        break;

    default:

        http_response_code(405);

        echo "Метод не поддерживается";
}   