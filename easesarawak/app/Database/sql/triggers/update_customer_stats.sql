-- Trigger: Update customer total orders and lifetime value
DELIMITER //

CREATE TRIGGER update_customer_stats
AFTER INSERT ON Orders
FOR EACH ROW
BEGIN
    UPDATE Users
    SET total_bookings = (
        SELECT COUNT(*)
        FROM Orders
        WHERE user_id = NEW.user_id
    ),
    lifetime_value = (
        SELECT COALESCE(SUM(total_amount), 0)
        FROM Orders
        WHERE user_id = NEW.user_id
        AND order_status = 'Completed'
    )
    WHERE user_id = NEW.user_id;
END//

DELIMITER ;
