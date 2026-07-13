<?php

namespace Jakzz\ExcelAnalog\Repositories;

use Jakzz\ExcelAnalog\Models\Table;


interface TableRepositoryInterface
{
    public function load(): Table;

    public function save(Table $table): void;
    
    public function updateCell(string $key, string $value): void;
}