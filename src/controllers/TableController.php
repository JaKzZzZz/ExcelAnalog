<?php

namespace Jakzz\ExcelAnalog\Controllers;

use Jakzz\ExcelAnalog\Repositories\TableRepositoryInterface; 
use Jakzz\ExcelAnalog\Models\Table;

use RuntimeException;

require_once __DIR__ . '/../../vendor/autoload.php';


class TableController
{
    private TableRepositoryInterface $repository;

    public function __construct(TableRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function load(): void
    {
        $table = $this->repository->load();

        echo json_encode($table);
    }
    public function save(): void
    {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!is_array($input)) {
            throw new RuntimeException("Некорректные данные");
        }

        $table = new Table(
            $input["rows"],
            $input["columns"],
            $input["cells"]
        );

        $this->repository->save($table);

        header("Content-Type: application/json");

        echo json_encode([
        "success" => true
    ]);
        
    }
}