<?php

namespace Jakzz\ExcelAnalog\Api;

define('PROJECT_ROOT', dirname(__DIR__, 2));

require_once __DIR__ . '/../../vendor/autoload.php';

use Jakzz\ExcelAnalog\Controllers\TableController;
use Jakzz\ExcelAnalog\Repositories\JsonTableRepository;

use Throwable;

header("Content-Type: application/json; charset=utf-8");

try {

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

        case "PATCH":
            $controller->update();
            break;

        default:

            http_response_code(405);

            header(
                "Allow: GET, POST, PATCH"
            );

            echo json_encode([
                "error" => "Метод не поддерживается"
            ]);

            break;
        }   
} catch (Throwable $e) {


    http_response_code(500);

    echo json_encode([
        "error" => $e->getMessage()
    ]);

}