<?php

require_once __DIR__ . '/../src/Bootstrap.php';
Bootstrap::run();

$populateWarehouse = \PopulateDb\WarehouseFactory::create(10);

$populateWarehouse->populate();
