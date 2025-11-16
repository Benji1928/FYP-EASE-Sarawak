-- ============================================
-- EASE SARAWAK - Database Views Setup
-- Run this script to create all required views
-- ============================================

-- Drop existing views if they exist
DROP VIEW IF EXISTS customer_lifetime_value;
DROP VIEW IF EXISTS daily_operations_summary;
DROP VIEW IF EXISTS monthly_revenue_analysis;

-- ============================================
-- 1. Customer Lifetime Value View
-- ============================================
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

-- ============================================
-- 2. Daily Operations Summary View
-- ============================================
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

-- ============================================
-- 3. Monthly Revenue Analysis View
-- ============================================
CREATE OR REPLACE VIEW monthly_revenue_analysis AS
SELECT
    DATE_FORMAT(transaction_date, '%Y-%m') as month,
    SUM(service_revenue) as service_revenue,
    SUM(delivery_revenue) as delivery_revenue,
    SUM(insurance_revenue) as insurance_revenue,
    SUM(partner_commission) as partner_commission,
    SUM(net_revenue) as net_revenue,
    COUNT(DISTINCT order_id) as transactions
FROM Revenue_Records
GROUP BY DATE_FORMAT(transaction_date, '%Y-%m');

-- ============================================
-- Verification - Show created views
-- ============================================
SELECT 'Views created successfully!' as status;
SHOW FULL TABLES WHERE Table_type = 'VIEW';
