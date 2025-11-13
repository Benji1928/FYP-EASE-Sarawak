-- Trigger: Automatically create revenue record when payment is completed
DELIMITER //

CREATE TRIGGER create_revenue_record
AFTER UPDATE ON Payments
FOR EACH ROW
BEGIN
    IF NEW.status = 'Paid' AND (OLD.status IS NULL OR OLD.status != 'Paid') THEN
        INSERT INTO Revenue_Records (
            order_id,
            transaction_date,
            service_revenue,
            delivery_revenue,
            insurance_revenue,
            partner_commission,
            net_revenue,
            revenue_channel,
            service_type
        )
        SELECT
            o.order_id,
            CURDATE(),
            o.base_price - o.delivery_fee - o.insurance_fee,
            o.delivery_fee,
            o.insurance_fee,
            CASE
                WHEN o.partner_id IS NOT NULL THEN
                    o.total_amount * (SELECT commission_rate FROM Partners WHERE partner_id = o.partner_id) / 100
                ELSE 0
            END,
            o.total_amount - o.discount_amount - CASE
                WHEN o.partner_id IS NOT NULL THEN
                    o.total_amount * (SELECT commission_rate FROM Partners WHERE partner_id = o.partner_id) / 100
                ELSE 0
            END,
            o.booking_channel,
            o.service_type
        FROM Orders o
        WHERE o.order_id = NEW.order_id;
    END IF;
END//

DELIMITER ;
