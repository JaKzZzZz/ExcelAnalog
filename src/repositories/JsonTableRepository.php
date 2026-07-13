<?php

namespace Jakzz\ExcelAnalog\Repositories;

use Jakzz\ExcelAnalog\Models\Table;

use RuntimeException;
use InvalidArgumentException;

require_once __DIR__ . '/../../vendor/autoload.php';


class JsonTableRepository implements TableRepositoryInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function load(): Table
    {
        if (!file_exists($this->filePath)) {

        $defaultTable = new Table(
            1,
            1,
            []
        );

        $this->save($defaultTable);

        return $defaultTable;
    }
    
        $jsonString = file_get_contents($this->filePath);
        $dataArray = json_decode($jsonString, true);

        if (!is_array($dataArray)) {
    throw new RuntimeException("Не удалось прочитать JSON");
}

        $this->validateData($dataArray);

        return new Table(
            $dataArray["rows"],
            $dataArray["columns"],
            $dataArray["cells"] ?? []
        );
    }

    public function save(Table $table): void
    {
        $dataArray = [
            "rows" => $table->rows,
            "columns" => $table->columns,
            "cells" => $table->cells
        ];

        $jsonString = json_encode($dataArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $result = file_put_contents($this->filePath, $jsonString, LOCK_EX);
        if ($result === false) {
            throw new RuntimeException("Не удалось сохранить JSON");
        }
    }

    private function validateData(array $data): void
    {
        if (!isset($data["rows"]) || !is_int($data["rows"])) {
            throw new InvalidArgumentException("Невалидное значение rows");
        }

        if (!isset($data["columns"]) || !is_int($data["columns"])) {
            throw new InvalidArgumentException("Невалидное значение columns");
        }

        if (!isset($data["cells"]) || !is_array($data["cells"])) {
            throw new InvalidArgumentException("Невалидное значение cells");
        }
    }
}