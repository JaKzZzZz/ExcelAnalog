<?php


interface TableRepositoryInterface
{
    public function load(): Table;

    public function save(Table $table): void;
}