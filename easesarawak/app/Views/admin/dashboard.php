<?= $this->include('admin/header'); ?>

            <div class="container">
                <div class="page-inner">
                    <div
                        class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">EASE Sarawak Admin Dashboard</h3>
                            <h6 class="op-7 mb-2">Quick overview of your business metrics</h6>
                        </div>
                        <div class="ms-md-auto py-2 py-md-0">
                            <a href="<?= base_url('report'); ?>" class="btn btn-label-info btn-round me-2">View Reports</a>
                            <a href="<?= base_url('order'); ?>" class="btn btn-primary btn-round">Manage Orders</a>
                        </div>
                    </div>
                    <!-- Primary Stats Row -->
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Total Users</p>
                                                <h4 class="card-title"><?= number_format($stats['total_users']); ?></h4>
                                                <small class="text-muted"><?= $stats['active_users']; ?> active</small>
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
                                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                                <i class="fas fa-truck"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Pending Deliveries</p>
                                                <h4 class="card-title"><?= number_format($stats['pending_deliveries']); ?></h4>
                                                <small class="text-muted"><?= $stats['on_time_rate']; ?>% on-time</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status Row -->
                    <div class="row">
                        <div class="col-sm-6 col-md-2">
                            <div class="card card-stats card-round">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h6 class="card-category mb-1">Pending</h6>
                                        <h4 class="card-title mb-0"><?= number_format($stats['pending_orders']); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <div class="card card-stats card-round">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h6 class="card-category mb-1">Confirmed</h6>
                                        <h4 class="card-title mb-0"><?= number_format($stats['confirmed_orders']); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <div class="card card-stats card-round">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h6 class="card-category mb-1">In Storage</h6>
                                        <h4 class="card-title mb-0"><?= number_format($stats['in_storage_orders']); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <div class="card card-stats card-round">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h6 class="card-category mb-1">Out for Delivery</h6>
                                        <h4 class="card-title mb-0"><?= number_format($stats['out_for_delivery']); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <div class="card card-stats card-round">
                                <div class="card-body p-3">
                                    <div class="text-center">
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
                                        <h6 class="card-category mb-1">Cancelled</h6>
                                        <h4 class="card-title mb-0 text-danger"><?= number_format($stats['cancelled_orders']); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Metrics Row -->
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                                <i class="fas fa-warehouse"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Storage Occupancy</p>
                                                <h4 class="card-title"><?= $stats['occupancy_rate']; ?>%</h4>
                                                <small class="text-muted"><?= $stats['current_occupancy']; ?> / <?= $stats['total_capacity']; ?></small>
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
                                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                <i class="fas fa-handshake"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Active Partners</p>
                                                <h4 class="card-title"><?= number_format($stats['active_partners']); ?></h4>
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
                                            <div class="icon-big text-center icon-danger bubble-shadow-small">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Open Incidents</p>
                                                <h4 class="card-title"><?= number_format($stats['open_incidents']); ?></h4>
                                                <small class="text-muted"><?= $stats['pending_claims']; ?> pending claims</small>
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
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Customer Rating</p>
                                                <h4 class="card-title"><?= $stats['avg_rating']; ?> / 5.0</h4>
                                                <small class="text-muted"><?= $stats['total_reviews']; ?> reviews</small>
                                            </div>
                                        </div>
                                    </div>
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
                                            <a href="<?= base_url('/order'); ?>" class="btn btn-primary btn-sm">View All</a>
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
                                                        <th>Order Date</th>
                                                        <th>Status</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($recent_orders as $order): ?>
                                                        <tr>
                                                            <td>#<?= esc($order->order_id); ?></td>
                                                            <td><?= esc($order->first_name . ' ' . $order->last_name); ?></td>
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
                                                            <td>RM <?= number_format($order->total_amount, 2); ?></td>
                                                            <td>
                                                                <a href="<?= base_url('/order'); ?>"
                                                                class="btn btn-sm btn-warning">
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
                                    <canvas id="revenueChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    // Revenue Chart
                    <?php if (!empty($revenue_chart['labels']) && !empty($revenue_chart['data'])): ?>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('revenueChart');
                        if (ctx) {
                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: <?= json_encode($revenue_chart['labels']); ?>,
                                    datasets: [{
                                        label: 'Revenue (RM)',
                                        data: <?= json_encode($revenue_chart['data']); ?>,
                                        borderColor: 'rgb(75, 192, 192)',
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
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
                        }
                    });
                    <?php endif; ?>
                    </script>
                </div>
            </div>
<?= $this->include('admin/footer'); ?>