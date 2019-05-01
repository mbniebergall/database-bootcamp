/**
 * Warehouse project create scripts for the database, tables, and initial data
 */

DROP DATABASE IF EXISTS warehouse;

CREATE DATABASE warehouse;


USE warehouse;

-- warehouse buildings
CREATE TABLE building (
    id INT NOT NULL AUTO_INCREMENT,
    code VARCHAR(20) NOT NULL,
    address VARCHAR(200) NULL,
    municipality VARCHAR(200) NULL,
    region VARCHAR(80) NULL,
    postal_code VARCHAR(20) NULL,
    country_code VARCHAR(2) NULL,

    PRIMARY KEY (id),

    CONSTRAINT UK_building_code
        UNIQUE KEY (code)

) ENGINE=INNODB;


-- racks available within the buildings
CREATE TABLE rack (
    id INT NOT NULL AUTO_INCREMENT,
    building_id INT NOT NULL,
    code VARCHAR(20) NOT NULL,

    PRIMARY KEY (id),

    CONSTRAINT UK_rack
        UNIQUE (code, building_id),

    CONSTRAINT FK_rack_building
        FOREIGN KEY (building_id)
        REFERENCES building (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE

) ENGINE=INNODB;


-- shelves available on a rack
CREATE TABLE shelf (
    id INT NOT NULL AUTO_INCREMENT,
    rack_id INT NOT NULL,
    code VARCHAR(20) NOT NULL,

    PRIMARY KEY (id),

    CONSTRAINT UK_shelf
        UNIQUE (rack_id, code),

    CONSTRAINT FK_shelf_rack
        FOREIGN KEY (rack_id)
        REFERENCES rack (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE

) ENGINE=INNODB;


-- locations available on a shelf
CREATE TABLE location (
    id INT NOT NULL AUTO_INCREMENT,
    shelf_id INT NOT NULL,
    code VARCHAR(20) NOT NULL,

    PRIMARY KEY (id),

    CONSTRAINT UK_location
        UNIQUE (code, shelf_id),

    CONSTRAINT FK_location_shelf
        FOREIGN KEY (shelf_id)
        REFERENCES shelf (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE

) ENGINE=INNODB;


-- items that can be stored in the warehouse
CREATE TABLE item (
    barcode VARCHAR(40) NOT NULL,
    description TEXT NULL,

    PRIMARY KEY (barcode)

) ENGINE=INNODB;


-- location items
CREATE TABLE location_item (
    location_id INT NOT NULL,
    item_barcode VARCHAR(40) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,

    PRIMARY KEY (location_id, item_barcode),

    CONSTRAINT UK_item_location
        UNIQUE (item_barcode, location_id),

    CONSTRAINT FK_item_location_item
        FOREIGN KEY (item_barcode)
        REFERENCES item (barcode)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT FK_item_location_id
        FOREIGN KEY (location_id)
        REFERENCES location (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE

) ENGINE=INNODB;
