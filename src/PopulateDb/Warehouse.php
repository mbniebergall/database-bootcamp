<?php

namespace PopulateDb;

use Faker\Generator;
use PDO;

class Warehouse
{
    public const DB_NAME = 'warehouse';

    /** @var \PDO */
    protected $db;

    /** @var Generator */
    protected $faker;

    /** @var int */
    protected $seedCount;

    /** @var array */
    protected $itemIds = [];

    public function __construct(
        \PDO $db,
        Generator $faker,
        $seedCount = 1
    ) {
        $this->db = $db;
        $this->faker = $faker;
        $this->seedCount = $seedCount;
    }

    public function populate()
    {
        $this->truncateDb();
        $this->populateTables();
    }

    protected function truncateDb()
    {
        $this->db->query('DELETE FROM item_location');
        $this->db->query('DELETE FROM item');
        $this->db->query('DELETE FROM location');
        $this->db->query('DELETE FROM shelf');
        $this->db->query('DELETE FROM rack');
        $this->db->query('DELETE FROM building');

        $this->db->query(
            "ALTER TABLE item_location
                AUTO_INCREMENT = 1"
        );

        $this->db->query(
            "ALTER TABLE item
                AUTO_INCREMENT = 1"
        );

        $this->db->query(
            "ALTER TABLE location
                AUTO_INCREMENT = 1"
        );

        $this->db->query(
            "ALTER TABLE shelf
                AUTO_INCREMENT = 1"
        );

        $this->db->query(
            "ALTER TABLE rack
                AUTO_INCREMENT = 1"
        );

        $this->db->query(
            "ALTER TABLE building
                AUTO_INCREMENT = 1"
        );
    }

    protected function populateTables()
    {
        $this->populateItems();

        $this->populateTableBuildings();
    }

    protected function populateTableBuildings()
    {
        for ($i = 1; $i < $this->seedCount + 1; $i++) {
            $query = 'INSERT INTO building
        VALUES (
            NULL,
            :code,
            :address,
            :municipality,
            :region,
            :postalCode,
            :countryCode
        )';

            $statement = $this->db->prepare(
                $query,
                [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
            );

            $statement->execute(
                [
                    ':code' => strtoupper($this->faker->randomLetter) . '-' . $i,
                    ':address' => $this->faker->streetAddress,
                    ':municipality' => $this->faker->city,
                    ':region' => strtoupper($this->faker->randomLetter . $this->faker->randomLetter),
                    ':postalCode' => $this->faker->postcode,
                    ':countryCode' => $this->faker->countryCode
                ]
            );

            $buildingId = $this->db->lastInsertId();

            $this->populateTableRacks($buildingId);
        }
    }

    protected function populateTableRacks(int $buildingId)
    {
        for ($i = 1; $i < $this->seedCount + 1; $i++) {
            $query = 'INSERT INTO rack (building_id, code)
                VALUES (
                    :buildingId,
                    :code
                )';

            $statement = $this->db->prepare(
                $query,
                [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
            );

            $statement->execute(
                [
                    ':buildingId' => $buildingId,
                    ':code' => strtoupper($this->faker->randomLetter) . '-' . $i
                ]
            );

            $rackId = $this->db->lastInsertId();

            $this->populateRackShelves($rackId);
        }
    }

    protected function populateRackShelves(int $rackId)
    {
        for ($i = 1; $i < $this->seedCount + 1; $i++) {
            $query = 'INSERT INTO shelf (rack_id, code)
                VALUES (
                    :rackId,
                    :code
                )';

            $statement = $this->db->prepare(
                $query,
                [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
            );

            $statement->execute(
                [
                    ':rackId' => $rackId,
                    ':code' => strtoupper($this->faker->randomLetter) . '-' . $i
                ]
            );

            $shelfId = $this->db->lastInsertId();

            $this->populateRackShelfLocations($shelfId);
        }
    }

    protected function populateRackShelfLocations(int $shelfId)
    {
        for ($i = 1; $i < $this->seedCount + 1; $i++) {
            $query = 'INSERT INTO location (shelf_id, code)
                VALUES (
                    :shelfId,
                    :code
                )';

            $statement = $this->db->prepare(
                $query,
                [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
            );

            $statement->execute(
                [
                    ':shelfId' => $shelfId,
                    ':code' => strtoupper($this->faker->randomLetter) . '-' . $i
                ]
            );

            $locationId = $this->db->lastInsertId();

            $this->populateRackShelfLocationItems($locationId);
        }
    }

    protected function populateRackShelfLocationItems(int $locationId)
    {
        for ($i = 1; $i < $this->seedCount + 1; $i++) {
            $query = 'INSERT INTO location_item (location_id, item_barcode, quantity)
                VALUES (
                    :locationId,
                    :itemBarcode,
                    :quantity
                )';

            $statement = $this->db->prepare(
                $query,
                [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
            );

            $statement->execute(
                [
                    ':locationId' => $locationId,
                    ':itemBarcode' => $this->faker->randomElement($this->itemIds),
                    ':quantity' => mt_rand(1, mt_getrandmax())
                ]
            );
        }
    }

    protected function populateItems()
    {
        $this->itemIds = [];
        for ($i = 1; $i < $this->seedCount + 1; $i++) {
            $query = 'INSERT INTO item (barcode, description)
                VALUES (
                    :barcode,
                    :description
                )';

            $statement = $this->db->prepare(
                $query,
                [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
            );

            $barcode = $this->faker->uuid;

            $statement->execute(
                [
                    ':barcode' => $barcode,
                    ':description' => $this->faker->realText(40)
                ]
            );

            $this->itemIds[] = $barcode;
        }
    }

}