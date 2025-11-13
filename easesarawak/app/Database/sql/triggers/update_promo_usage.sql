-- Trigger: Update promo code usage
DELIMITER //

CREATE TRIGGER update_promo_usage
AFTER INSERT ON Orders
FOR EACH ROW
BEGIN
    IF NEW.promo_code IS NOT NULL THEN
        UPDATE Promo
        SET times_used = times_used + 1
        WHERE promo_code = NEW.promo_code;
    END IF;
END//

DELIMITER ;
