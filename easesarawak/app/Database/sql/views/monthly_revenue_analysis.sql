-- Monthly Revenue Analysis View
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
