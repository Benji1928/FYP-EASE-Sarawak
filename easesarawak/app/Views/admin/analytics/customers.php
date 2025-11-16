<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3"><?= esc($title ?? 'Customer Analytics'); ?></h3>
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
                    <a href="#">Analytics</a>
                </li>
                <li class="separator">
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="nav-item">Customers</li>
            </ul>
        </div>

        <!-- Customer Segmentation -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Customer Segmentation by Type</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Customer Type</th>
                                        <th class="text-end">Count</th>
                                        <th class="text-end">Avg Lifetime Value (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($customer_by_type)): ?>
                                        <?php foreach ($customer_by_type as $type): ?>
                                            <tr>
                                                <td>
                                                    <span class="badge badge-primary"><?= esc($type->customer_type ?? 'Standard'); ?></span>
                                                </td>
                                                <td class="text-end"><?= number_format($type->count); ?></td>
                                                <td class="text-end">RM <?= number_format($type->avg_lifetime_value ?? 0, 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No customer data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Top 50 Customers by Lifetime Value</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th class="text-end">Total Orders</th>
                                        <th class="text-end">Total Spent (RM)</th>
                                        <th class="text-end">Avg Order Value (RM)</th>
                                        <th class="text-end">Avg Rating</th>
                                        <th>Last Order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($top_customers)): ?>
                                        <?php foreach ($top_customers as $index => $customer): ?>
                                            <tr>
                                                <td><?= $index + 1; ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/users/view/' . $customer->user_id); ?>">
                                                        <?= esc($customer->first_name . ' ' . $customer->last_name); ?>
                                                    </a>
                                                </td>
                                                <td><?= esc($customer->email); ?></td>
                                                <td>
                                                    <span class="badge badge-info"><?= esc($customer->customer_type ?? 'Standard'); ?></span>
                                                </td>
                                                <td class="text-end"><?= number_format($customer->total_orders); ?></td>
                                                <td class="text-end"><strong>RM <?= number_format($customer->total_spent ?? 0, 2); ?></strong></td>
                                                <td class="text-end">RM <?= number_format($customer->average_order_value ?? 0, 2); ?></td>
                                                <td class="text-end">
                                                    <?php if ($customer->average_rating): ?>
                                                        <span class="badge badge-success">
                                                            <i class="fa fa-star"></i> <?= number_format($customer->average_rating, 1); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($customer->last_order_date): ?>
                                                        <?= date('M d, Y', strtotime($customer->last_order_date)); ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">No orders</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No customer data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Acquisition Trend -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Customer Acquisition Trend (Last 12 Months)</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Source</th>
                                        <th class="text-end">New Customers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($acquisition_trend)): ?>
                                        <?php foreach ($acquisition_trend as $trend): ?>
                                            <tr>
                                                <td><?= esc($trend->month); ?></td>
                                                <td>
                                                    <span class="badge badge-secondary"><?= esc($trend->source_of_booking ?? 'Unknown'); ?></span>
                                                </td>
                                                <td class="text-end"><?= number_format($trend->new_customers); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No acquisition data available</td>
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
