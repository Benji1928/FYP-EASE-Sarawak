-- Customer Lifetime Value View
CREATE OR REPLACE VIEW customer_lifetime_value AS
SELECT
    u.user_id,
    u.first_name,
    u.last_name,
    u.email,
    u.customer_type,
    COUNT(o.order_id) as total_orders,
    SUM(o.total_amount) as total_spent,
    AVG(o.total_amount) as average_order_value,
    MIN(o.created_date) as first_order_date,
    MAX(o.created_date) as last_order_date,
    AVG(r.rating) as average_rating
FROM Users u
LEFT JOIN Orders o ON u.user_id = o.user_id
LEFT JOIN Reviews r ON u.user_id = r.user_id
GROUP BY u.user_id, u.first_name, u.last_name, u.email, u.customer_type;
