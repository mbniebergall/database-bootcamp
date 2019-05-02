/**
 * Inventory project to track inventory
 */

DROP DATABASE IF EXISTS inventor;

CREATE DATABASE inventory;


USE inventory;


CREATE TABLE food_inventory (
    item_number INT NOT NULL,
    description VARCHAR(2400) NOT NULL,
    vendor VARCHAR(200) NOT NULL,
    category VARCHAR(200) NOT NULL,
    size INT NOT NULL DEFAULT 0,
    unit VARCHAR(40) NOT NULL DEFAULT '0',
    starting_quantity DECIMAL(5, 2) NOT NULL DEFAULT 0,
    starting_value DECIMAL(7, 2) NOT NULL DEFAULT 0,
    week_one_quantity DECIMAL(5, 2) NOT NULL DEFAULT 0,
    week_one_cost DECIMAL(7, 2) NOT NULL DEFAULT 0,
    week_two_quanity DECIMAL(5, 2) NOT NULL DEFAULT 0,
    week_two_cost DECIMAL(7, 2) NOT NULL DEFAULT 0,
    week_three_quantity DECIMAL(5, 2) NOt NULL DEFAULT 0,
    week_three_cost DECIMAL(7, 2) NOT NULL DEFAULT 0
) ENGINE=INNODB;


