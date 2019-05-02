
USE warehouse;

EXPLAIN
SELECT COUNT(b.code) AS building_code_count,
       b.code,
       i.description
FROM building b
JOIN rack r
    ON r.building_id = b.id
JOIN shelf s
    ON s.rack_id = r.id
JOIN location l
    ON s.id = l.shelf_id
JOIN location_item li
    ON l.id = li.location_id
JOIN item i
    ON i.barcode = li.item_barcode

WHERE b.code LIKE '%5%'
AND i.description LIKE '%pig%'

GROUP BY b.code, i.description;

