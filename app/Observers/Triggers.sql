--before insert order, duplicate verification
DELIMITER $$
CREATE TRIGGER get_duplicates
BEFORE INSERT ON orders

FOR EACH ROW
BEGIN
    DECLARE existedeja INTEGER;

    SELECT EXISTS( SELECT RIGHT(phone,9) as phone
      FROM orders
      WHERE CAST((created_at) as date) >= DATE_SUB(CAST( NOW() AS Date ), INTERVAL 5 DAY)
      and (status != 'cancelled')
      and investor_id = NEW.investor_id
      and
        RIGHT(phone, 9) = RIGHT(NEW.phone, 9)
    ) INTO existedeja;

    IF existedeja THEN
        Set NEW.duplicate = true;
    END IF;
END
$$
DELIMITER ;


-- before adding order to orders table, wrong numbers
DELIMITER $$
CREATE TRIGGER get_wrong_numbers
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
    if LENGTH(REPLACE(new.phone, ' ', '')) < 9 THEN
        SET new.status = 'wrong number';
    END IF;
END
$$
DELIMITER ;
