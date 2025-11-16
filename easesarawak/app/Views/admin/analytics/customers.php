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

        <!-- Export Controls -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-wrap gap-2 mb-2">
                            <h5 class="mb-0">Export Customer Insights</h5>
                            <small class="text-muted">Choose a dataset and download it in your preferred format</small>
                        </div>
                        <form method="get" action="<?= base_url('admin/analytics/export/customers'); ?>" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Dataset</label>
                                    <select name="section" class="form-control">
                                        <option value="lifetime">Top Customers</option>
                                        <option value="segments">Customer Segments</option>
                                        <option value="acquisition">Acquisition Trend</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Format</label>
                                    <select name="format" class="form-control">
                                        <option value="csv">CSV</option>
                                        <option value="pdf">PDF</option>
                                        <option value="json">JSON</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-outline-primary w-100">
                                        <i class="fa fa-download"></i> Export
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
