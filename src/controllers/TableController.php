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
        $table = $this->repository->load();

        echo json_encode($table);
    }
    public function save(): void
    {
        $input = json_decode(file_get_contents("php://input"), true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($input)) {
            throw new RuntimeException("Некорректные данные");
        }

        TableValidator::validateTable($input);

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
    public function update(): void
{

    $input = json_decode(
        file_get_contents("php://input"),
        true
    );


    if (!is_array($input)) {

        throw new RuntimeException("Некорректные данные");

    }


    TableValidator::validateData($input);


    $key = $input["row"] . "-" . $input["col"];


    $this->repository->updateCell(
        $key,
        $input["value"]
    );


    echo json_encode([
        "success" => true
    ]);
}
}