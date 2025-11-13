-- Daily Operations Summary View
CREATE OR REPLACE VIEW daily_operations_summary AS
SELECT
    DATE(o.pickup_time) as operation_date,
    COUNT(DISTINCT o.order_id) as total_orders,
    COUNT(DISTINCT CASE WHEN o.service_type = 'Storage' THEN o.order_id END) as storage_orders,
    COUNT(DISTINCT CASE WHEN o.service_type IN ('Delivery', 'Storage_Delivery') THEN o.order_id END) as delivery_orders,
    SUM(o.number_of_bags) as total_bags_processed,
    COUNT(DISTINCT CASE WHEN o.order_status = 'Completed' THEN o.order_id END) as completed_orders,
    COUNT(DISTINCT CASE WHEN o.order_status = 'Cancelled' THEN o.order_id END) as cancelled_orders,
    COALESCE(AVG(CASE WHEN d.on_time = 1 THEN 1 ELSE 0 END) * 100, 0) as on_time_delivery_rate,
    SUM(o.total_amount) as daily_revenue
FROM Orders o
LEFT JOIN Delivery d ON o.order_id = d.order_id
GROUP BY DATE(o.pickup_time);
