<?php

class Table
{
    public int $rows;
    public int $columns;
    public array $cells;

    public function __construct(
        int $rows,
        int $columns,
        array $cells = []
    ) {
        $this->rows = $rows;
        $this->columns = $columns;
        $this->cells = $cells;
    }
}