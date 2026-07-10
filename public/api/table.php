<?php

require_once '../../src/controllers/TableController.php';


$repository = new JsonTableRepository();

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