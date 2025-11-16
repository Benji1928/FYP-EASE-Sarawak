<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3"><?= esc($title ?? 'Partner Performance'); ?></h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="<?= base_url('admin'); ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/partners'); ?>">Partners</a>
                </li>
                <li class="separator">
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="nav-item">Performance</li>
            </ul>
        </div>

        <!-- Partner Info Card -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-handshake"></i> <?= esc($partner['name'] ?? 'Partner'); ?>
                            </h4>
                            <div class="ms-auto">
                                <?php if ($partner['is_active']): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Inactive</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <p><strong>Type:</strong><br>
                                    <span class="badge badge-info"><?= esc($partner['type'] ?? 'N/A'); ?></span>
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Commission Rate:</strong><br>
                                    <?= number_format($partner['commission_rate'] ?? 0, 2); ?>%
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Contact Person:</strong><br>
                                    <?= esc($partner['contact_person'] ?? 'N/A'); ?>
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Email:</strong><br>
                                    <?= esc($partner['contact_email'] ?? 'N/A'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="<?= base_url('admin/partners/edit/' . $partner['partner_id']); ?>" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i> Edit Partner
                                </a>
                                <a href="<?= base_url('admin/partners'); ?>" class="btn btn-secondary btn-sm">
                                    <i class="fa fa-arrow-left"></i> Back to Partners
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fas fa-chart-line"></i> Performance Metrics
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Period</th>
                                        <th class="text-end">Total Bookings</th>
                                        <th class="text-end">Revenue Generated (RM)</th>
                                        <th class="text-end">Commission Paid (RM)</th>
                                        <th class="text-end">Avg Rating</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($performance)): ?>
                                        <?php
                                        $totalBookings = 0;
                                        $totalRevenue = 0;
                                        $totalCommission = 0;
                                        ?>
                                        <?php foreach ($performance as $perf): ?>
                                            <?php
                                            $totalBookings += $perf->total_bookings ?? 0;
                                            $totalRevenue += $perf->revenue_generated ?? 0;
                                            $totalCommission += $perf->commission_paid ?? 0;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?= date('M d, Y', strtotime($perf->period_start)); ?>
                                                    -
                                                    <?= date('M d, Y', strtotime($perf->period_end)); ?>
                                                </td>
                                                <td class="text-end"><?= number_format($perf->total_bookings ?? 0); ?></td>
                                                <td class="text-end">RM <?= number_format($perf->revenue_generated ?? 0, 2); ?></td>
                                                <td class="text-end">RM <?= number_format($perf->commission_paid ?? 0, 2); ?></td>
                                                <td class="text-end">
                                                    <?php if ($perf->avg_rating): ?>
                                                        <span class="badge badge-success">
                                                            <i class="fa fa-star"></i> <?= number_format($perf->avg_rating, 1); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $bookings = $perf->total_bookings ?? 0;
                                                    if ($bookings >= 50) echo '<span class="badge badge-success">Excellent</span>';
                                                    elseif ($bookings >= 20) echo '<span class="badge badge-info">Good</span>';
                                                    elseif ($bookings >= 10) echo '<span class="badge badge-warning">Fair</span>';
                                                    else echo '<span class="badge badge-secondary">Low</span>';
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr class="table-active">
                                            <td><strong>Total</strong></td>
                                            <td class="text-end"><strong><?= number_format($totalBookings); ?></strong></td>
                                            <td class="text-end"><strong>RM <?= number_format($totalRevenue, 2); ?></strong></td>
                                            <td class="text-end"><strong>RM <?= number_format($totalCommission, 2); ?></strong></td>
                                            <td colspan="2"></td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                <i class="fas fa-info-circle"></i> No performance data available
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fas fa-clipboard-list"></i> Recent Orders (Last 50)
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Service Type</th>
                                        <th>Customer</th>
                                        <th class="text-end">Amount (RM)</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($orders)): ?>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td>#<?= esc($order->order_id); ?></td>
                                                <td><?= esc($order->service_type ?? 'N/A'); ?></td>
                                                <td>
                                                    <?php if (isset($order->user_id)): ?>
                                                        <a href="<?= base_url('admin/users/view/' . $order->user_id); ?>">
                                                            User #<?= $order->user_id; ?>
                                                        </a>
                                                    <?php else: ?>
                                                        N/A
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">RM <?= number_format($order->total_amount ?? 0, 2); ?></td>
                                                <td>
                                                    <?php
                                                    $status = $order->order_status ?? 'Pending';
                                                    $badgeClass = 'badge-secondary';
                                                    switch($status) {
                                                        case 'Completed': $badgeClass = 'badge-success'; break;
                                                        case 'Confirmed': $badgeClass = 'badge-info'; break;
                                                        case 'In_Storage': $badgeClass = 'badge-primary'; break;
                                                        case 'Out-for-Delivery': $badgeClass = 'badge-warning'; break;
                                                        case 'Cancelled': $badgeClass = 'badge-danger'; break;
                                                    }
                                                    ?>
                                                    <span class="badge <?= $badgeClass; ?>"><?= esc($status); ?></span>
                                                </td>
                                                <td><?= date('M d, Y', strtotime($order->created_date)); ?></td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('admin/orders/view/' . $order->order_id); ?>"
                                                       class="btn btn-sm btn-info">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                <i class="fas fa-info-circle"></i> No orders found for this partner
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/footer'); ?>
