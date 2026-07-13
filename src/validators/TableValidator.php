<?php

namespace Jakzz\ExcelAnalog\Validators;
use InvalidArgumentException;

class TableValidator
{
    public static function validateData(array $data): void
    {
        if (!isset($data["rows"]) || !is_int($data["rows"])) {
            throw new InvalidArgumentException("Невалидное значение rows");
        }

        if (!isset($data["columns"]) || !is_int($data["columns"])) {
            throw new InvalidArgumentException("Невалидное значение columns");
        }

        if ($data["rows"] < 1 || $data["columns"] < 1) {
            throw new InvalidArgumentException("Размер таблицы должен быть больше нуля");
        }

        if (!isset($data["cells"]) || !is_array($data["cells"])) {
            throw new InvalidArgumentException("Невалидное значение cells");
        }
    }
}