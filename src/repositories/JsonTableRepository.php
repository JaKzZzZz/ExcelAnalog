<?php

namespace Jakzz\ExcelAnalog\Repositories;

use Jakzz\ExcelAnalog\Models\Table;
use Jakzz\ExcelAnalog\Validators\TableValidator;

use RuntimeException;

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

        TableValidator::validateTable($dataArray);

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
    public function updateCell(string $key, string $value): void
    {
            $fp = fopen($this->filePath, "c+");

        if (!$fp) {
            throw new RuntimeException("Не удалось открыть файл");
        }

        flock($fp, LOCK_EX);

        $contents = stream_get_contents($fp);

        $data = $contents
        ? json_decode($contents, true)
        : [
            "rows" => 1,
            "columns" => 1,
            "cells" => []
        ];


        if ($value === "") {

            unset($data["cells"][$key]);

        } else {

            $data["cells"][$key] = $value;

        }

        rewind($fp);
        ftruncate($fp, 0);


        fwrite(
        $fp,
        json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        fflush($fp);

        flock($fp, LOCK_UN);

        fclose($fp);
    }
}