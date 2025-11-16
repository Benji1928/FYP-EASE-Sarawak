<!-- Old Data & Report Page -->
<?= $this->include('admin/header'); ?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Orders Report & Analytics</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="<?= base_url('/dashboard'); ?>">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Reports</a>
                            </li>
                            <li class="separator">
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="nav-item">Orders Report</li>
                        </ul>
                    </div>

                    <!-- Order Status Overview -->
                    <div class="row">
            <div class="col-sm-6 col-md-2">
                <div class="card card-stats card-round">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="icon-big text-center icon-warning mb-2">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <h6 class="card-category mb-1">Pending</h6>
                            <h4 class="card-title mb-0 text-warning"><?= number_format($stats['pending_orders']); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card card-stats card-round">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="icon-big text-center icon-info mb-2">
                                <i class="fas fa-check"></i>
                            </div>
                            <h6 class="card-category mb-1">Confirmed</h6>
                            <h4 class="card-title mb-0 text-info"><?= number_format($stats['confirmed_orders']); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card card-stats card-round">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="icon-big text-center icon-primary mb-2">
                                <i class="fas fa-warehouse"></i>
                            </div>
                            <h6 class="card-category mb-1">In Storage</h6>
                            <h4 class="card-title mb-0 text-primary"><?= number_format($stats['in_storage_orders']); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card card-stats card-round">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="icon-big text-center icon-secondary mb-2">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <h6 class="card-category mb-1">Out for Delivery</h6>
                            <h4 class="card-title mb-0 text-secondary"><?= number_format($stats['out_for_delivery']); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card card-stats card-round">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="icon-big text-center icon-success mb-2">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <h6 class="card-category mb-1">Completed</h6>
                            <h4 class="card-title mb-0 text-success"><?= number_format($stats['completed_orders']); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card card-stats card-round">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="icon-big text-center icon-danger mb-2">
                                <i class="fas fa-times"></i>
                            </div>
                            <h6 class="card-category mb-1">Cancelled</h6>
                            <h4 class="card-title mb-0 text-danger"><?= number_format($stats['cancelled_orders']); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics Row -->
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Orders</p>
                                    <h4 class="card-title"><?= number_format($stats['total_orders']); ?></h4>
                                    <small class="text-muted"><?= $stats['orders_today']; ?> today</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Revenue (This Month)</p>
                                    <h4 class="card-title">RM <?= number_format($stats['revenue_month'], 2); ?></h4>
                                    <small class="text-muted">Total: RM <?= number_format($stats['total_revenue'], 2); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-calculator"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Avg Order Value</p>
                                    <h4 class="card-title">RM <?= number_format($stats['avg_order_value'], 2); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Pending Payments</p>
                                    <h4 class="card-title"><?= number_format($stats['pending_payments']); ?></h4>
                                    <small class="text-muted">RM <?= number_format($stats['pending_payment_amount'], 2); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <h4 class="card-title">Revenue Trend (Last 7 Days)</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        // Check if there's meaningful revenue data
                        $hasChartData = false;

                        if (isset($revenue_chart) && is_array($revenue_chart)) {
                            if (isset($revenue_chart['labels']) && isset($revenue_chart['data'])) {
                                if (is_array($revenue_chart['labels']) && is_array($revenue_chart['data'])) {
                                    $labelCount = count($revenue_chart['labels']);
                                    $dataCount = count($revenue_chart['data']);

                                    // Check if we have data AND if there's any actual revenue
                                    if ($labelCount > 0 && $dataCount > 0) {
                                        $totalRevenue = array_sum($revenue_chart['data']);
                                        // Only show chart if there's actual revenue or multiple data points
                                        if ($totalRevenue > 0 || $labelCount >= 3) {
                                            $hasChartData = true;
                                        }
                                    }
                                }
                            }
                        }
                        ?>

                        <?php if ($hasChartData): ?>
                            <div style="height: 300px; position: relative;">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        <?php else: ?>
                            <div style="padding: 60px 20px; text-align: center; background: #f8f9fa; border-radius: 8px; min-height: 300px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <i class="fas fa-chart-line" style="font-size: 48px; color: #6c757d; margin-bottom: 20px;"></i>
                                <h5 style="color: #495057; margin-bottom: 10px;">No Revenue Data Available</h5>
                                <p style="color: #6c757d; margin-bottom: 5px;">No orders with revenue found in the last 7 days</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Recent Orders</div>
                            <div class="card-tools">
                                <a href="<?= base_url('/order'); ?>" class="btn btn-primary btn-sm">View All Orders</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recent_orders)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Email</th>
                                            <th>Order Date</th>
                                            <th>Status</th>
                                            <th class="text-end">Amount</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recent_orders as $order): ?>
                                            <tr>
                                                <td><strong>#<?= esc($order->order_id); ?></strong></td>
                                                <td><?= esc($order->first_name . ' ' . $order->last_name); ?></td>
                                                <td><?= esc($order->email); ?></td>
                                                <td><?= date('M d, Y H:i', strtotime($order->created_date)); ?></td>
                                                <td>
                                                    <?php
                                                    $statusColors = [
                                                        'Pending' => 'warning',
                                                        'Confirmed' => 'info',
                                                        'In_Storage' => 'primary',
                                                        'Out-for-Delivery' => 'secondary',
                                                        'Completed' => 'success',
                                                        'Cancelled' => 'danger'
                                                    ];
                                                    $color = $statusColors[$order->order_status] ?? 'secondary';
                                                    ?>
                                                    <span class="badge badge-<?= $color; ?>"><?= str_replace('_', ' ', $order->order_status); ?></span>
                                                </td>
                                                <td class="text-end"><strong>RM <?= number_format($order->total_amount, 2); ?></strong></td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('/order'); ?>" class="btn btn-sm btn-warning">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No recent orders found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Revenue Chart
<?php if ($hasChartData): ?>
(function() {
    // Ensure Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded');
        return;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart');
        if (!ctx) {
            console.warn('Revenue chart canvas not found');
            return;
        }

        try {
            // Destroy existing chart instance if it exists
            const existingChart = Chart.getChart(ctx);
            if (existingChart) {
                existingChart.destroy();
            }

            // Create new chart
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($revenue_chart['labels']); ?>,
                    datasets: [{
                        label: 'Revenue (RM)',
                        data: <?= json_encode($revenue_chart['data']); ?>,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'RM ' + value.toFixed(2);
                                }
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error creating revenue chart:', error);
        }
    });
})();
<?php endif; ?>
</script>

<?= $this->include('admin/footer'); ?>
