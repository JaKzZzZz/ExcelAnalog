<?php

namespace Jakzz\ExcelAnalog\Controllers;

use Jakzz\ExcelAnalog\Repositories\TableRepositoryInterface; 
use Jakzz\ExcelAnalog\Models\Table;
use Jakzz\ExcelAnalog\Validators\TableValidator;

use RuntimeException;


class TableController
{
    private TableRepositoryInterface $repository;

    public function __construct(TableRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function load(): void
    {
        header("Content-Type: application/json");

        $table = $this->repository->load();

        echo json_encode($table);
    }
    public function save(): void
    {
        header("Content-Type: application/json");

        $input = json_decode(file_get_contents("php://input"), true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($input)) {
            throw new RuntimeException("Некорректные данные");
        }

        TableValidator::validateData($input);

        $table = new Table(
            $input["rows"],
            $input["columns"],
            $input["cells"]
        );

        $this->repository->save($table);

        echo json_encode([
        "success" => true
    ]);
        
    }
}