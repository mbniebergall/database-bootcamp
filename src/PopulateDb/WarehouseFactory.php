<?php


namespace PopulateDb;

use Faker\Factory;

class WarehouseFactory
{
    public static function create($seedCount = 1)
    {
        return new Warehouse(
            new \PDO(
                'mysql:dbname=warehouse;host=127.0.0.1;port=3311', 'root', 'root'
            ),
            Factory::create(),
            $seedCount
        );
    }
}