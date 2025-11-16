<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3"><?= esc($title ?? 'Operations Analytics'); ?></h3>
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
                <li class="nav-item">Operations</li>
            </ul>
        </div>

        <!-- Date Range Filter -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="get" action="<?= base_url('admin/analytics/operations'); ?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="<?= esc($start_date); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" name="end_date" class="form-control" value="<?= esc($end_date); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary form-control">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Controls -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-wrap gap-2 mb-2">
                            <h5 class="mb-0">Export Operations Data</h5>
                            <small class="text-muted">Apply the current date filters, pick a dataset, and download</small>
                        </div>
                        <form method="get" action="<?= base_url('admin/analytics/export/operations'); ?>" class="row g-3 align-items-end">
                            <input type="hidden" name="start_date" value="<?= esc($start_date); ?>">
                            <input type="hidden" name="end_date" value="<?= esc($end_date); ?>">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Dataset</label>
                                    <select name="section" class="form-control">
                                        <option value="daily">Daily Summary</option>
                                        <option value="delivery">Delivery Performance</option>
                                        <option value="storage">Storage Occupancy</option>
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

        <!-- Storage Occupancy -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Storage Location Occupancy</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Location</th>
                                        <th>Category</th>
                                        <th class="text-end">Capacity</th>
                                        <th class="text-end">Current</th>
                                        <th class="text-end">Occupancy Rate</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($storage_occupancy)): ?>
                                        <?php foreach ($storage_occupancy as $location): ?>
                                            <tr>
                                                <td><?= esc($location->name); ?></td>
                                                <td><span class="badge badge-secondary"><?= esc($location->category); ?></span></td>
                                                <td class="text-end"><?= number_format($location->total_capacity); ?></td>
                                                <td class="text-end"><?= number_format($location->current_occupancy); ?></td>
                                                <td class="text-end">
                                                    <div class="progress" style="width: 100px; height: 20px;">
                                                        <div class="progress-bar <?php
                                                            if ($location->occupancy_rate >= 90) echo 'bg-danger';
                                                            elseif ($location->occupancy_rate >= 75) echo 'bg-warning';
                                                            else echo 'bg-success';
                                                        ?>" role="progressbar" style="width: <?= $location->occupancy_rate; ?>%">
                                                            <?= number_format($location->occupancy_rate, 1); ?>%
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if ($location->occupancy_rate >= 90): ?>
                                                        <span class="badge badge-danger">Critical</span>
                                                    <?php elseif ($location->occupancy_rate >= 75): ?>
                                                        <span class="badge badge-warning">High</span>
                                                    <?php elseif ($location->occupancy_rate >= 50): ?>
                                                        <span class="badge badge-info">Moderate</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-success">Normal</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No storage location data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Operations Summary -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daily Operations Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th class="text-end">Total Orders</th>
                                        <th class="text-end">Storage</th>
                                        <th class="text-end">Delivery</th>
                                        <th class="text-end">Bags Processed</th>
                                        <th class="text-end">Completed</th>
                                        <th class="text-end">Cancelled</th>
                                        <th class="text-end">On-Time Rate</th>
                                        <th class="text-end">Revenue (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($daily_ops)): ?>
                                        <?php foreach ($daily_ops as $day): ?>
                                            <tr>
                                                <td><?= date('M d, Y', strtotime($day->operation_date)); ?></td>
                                                <td class="text-end"><strong><?= number_format($day->total_orders); ?></strong></td>
                                                <td class="text-end"><?= number_format($day->storage_orders); ?></td>
                                                <td class="text-end"><?= number_format($day->delivery_orders); ?></td>
                                                <td class="text-end"><?= number_format($day->total_bags_processed); ?></td>
                                                <td class="text-end">
                                                    <span class="badge badge-success"><?= number_format($day->completed_orders); ?></span>
                                                </td>
                                                <td class="text-end">
                                                    <span class="badge badge-danger"><?= number_format($day->cancelled_orders); ?></span>
                                                </td>
                                                <td class="text-end">
                                                    <?php $rate = $day->on_time_delivery_rate; ?>
                                                    <span class="badge <?php
                                                        if ($rate >= 95) echo 'badge-success';
                                                        elseif ($rate >= 85) echo 'badge-warning';
                                                        else echo 'badge-danger';
                                                    ?>">
                                                        <?= number_format($rate, 1); ?>%
                                                    </span>
                                                </td>
                                                <td class="text-end">RM <?= number_format($day->daily_revenue, 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No operations data available for the selected period</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Performance -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Delivery Performance</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th class="text-end">Total Deliveries</th>
                                        <th class="text-end">On-Time</th>
                                        <th class="text-end">Avg Duration (min)</th>
                                        <th class="text-end">Avg Delay (min)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($delivery_performance)): ?>
                                        <?php foreach ($delivery_performance as $perf): ?>
                                            <tr>
                                                <td><?= date('M d, Y', strtotime($perf->date)); ?></td>
                                                <td class="text-end"><?= number_format($perf->total_deliveries); ?></td>
                                                <td class="text-end">
                                                    <span class="badge badge-success">
                                                        <?= number_format($perf->on_time_deliveries); ?>
                                                    </span>
                                                </td>
                                                <td class="text-end"><?= number_format($perf->avg_duration, 0); ?> min</td>
                                                <td class="text-end">
                                                    <?php if ($perf->avg_delay > 0): ?>
                                                        <span class="text-danger"><?= number_format($perf->avg_delay, 0); ?> min</span>
                                                    <?php else: ?>
                                                        <span class="text-success">0 min</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No delivery performance data available</td>
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
