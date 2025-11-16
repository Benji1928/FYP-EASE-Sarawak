<?= $this->include('admin/header'); ?>

<?php
    $operationsExportStart = $operationsExportStart ?? date('Y-m-01');
    $operationsExportEnd = $operationsExportEnd ?? date('Y-m-d');
?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Operations Report & Analytics</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="<?= base_url('/admin'); ?>">
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
                            <li class="nav-item">Operations Report</li>
                        </ul>
                    </div>

                    <!-- Export Controls -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card card-round">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
                                        <h5 class="mb-0">Export Operations Analytics</h5>
                                        <small class="text-muted">Download detailed datasets for auditing or sharing.</small>
                                    </div>
                                    <form method="get" action="<?= base_url('admin/analytics/export/operations'); ?>" class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Dataset</label>
                                            <select name="section" class="form-control">
                                                <option value="daily">Daily Summary</option>
                                                <option value="delivery">Delivery Performance</option>
                                                <option value="storage">Storage Occupancy</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Format</label>
                                            <select name="format" class="form-control">
                                                <option value="csv">CSV</option>
                                                <option value="pdf">PDF</option>
                                                <option value="json">JSON</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" name="start_date" value="<?= esc($operationsExportStart); ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">End Date</label>
                                            <input type="date" name="end_date" value="<?= esc($operationsExportEnd); ?>" class="form-control">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-outline-primary">
                                                <i class="fa fa-download"></i> Export Data
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Operational Overview Stats -->
        <div class="row">
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
                                    <small class="text-muted"><?= $stats['on_time_rate']; ?>% on-time rate</small>
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
        </div>

        <!-- Staff Performance and Active Staff -->
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-users-cog"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Active Staff</p>
                                    <h4 class="card-title"><?= number_format($stats['active_staff']); ?></h4>
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
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">In Storage</p>
                                    <h4 class="card-title"><?= number_format($stats['in_storage_orders']); ?></h4>
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
                                    <i class="fas fa-shipping-fast"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Out for Delivery</p>
                                    <h4 class="card-title"><?= number_format($stats['out_for_delivery']); ?></h4>
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
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Pending Orders</p>
                                    <h4 class="card-title"><?= number_format($stats['pending_orders']); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Driver/Staff Performance Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Driver Performance</div>
                            <div class="card-tools">
                                <span class="badge badge-info"><?= count($staff_performance); ?> Drivers</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Driver Name</th>
                                        <th>Role</th>
                                        <th class="text-end">Total Deliveries</th>
                                        <th class="text-end">On-Time %</th>
                                        <th class="text-end">Total Distance (km)</th>
                                        <th class="text-center">Performance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($staff_performance)):
                                        foreach ($staff_performance as $staff):
                                            $onTimePercentage = $staff->on_time_percentage ?? 0;
                                            $performanceClass = 'success';
                                            if ($onTimePercentage < 70) $performanceClass = 'danger';
                                            elseif ($onTimePercentage < 85) $performanceClass = 'warning';
                                    ?>
                                        <tr>
                                            <td>
                                                <div><strong><?= esc($staff->staff_name); ?></strong></div>
                                                <small class="text-muted">#<?= esc($staff->staff_id); ?></small>
                                            </td>
                                            <td><?= esc($staff->role); ?></td>
                                            <td class="text-end">
                                                <span class="badge badge-primary"><?= number_format($staff->total_deliveries ?? 0); ?></span>
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-<?= $performanceClass; ?>"><?= number_format($onTimePercentage, 1); ?>%</strong>
                                            </td>
                                            <td class="text-end"><?= number_format($staff->total_distance ?? 0, 1); ?> km</td>
                                            <td class="text-center">
                                                <?php if ($onTimePercentage >= 85): ?>
                                                    <span class="badge badge-success">Excellent</span>
                                                <?php elseif ($onTimePercentage >= 70): ?>
                                                    <span class="badge badge-warning">Good</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Needs Improvement</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No staff performance data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Incidents -->
        <?php if (!empty($recent_incidents) && count($recent_incidents) > 0): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Recent Incidents</div>
                            <div class="card-tools">
                                <span class="badge badge-danger"><?= count($recent_incidents); ?> Recent</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Incident ID</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Severity</th>
                                        <th>Status</th>
                                        <th>Customer</th>
                                        <th>Order ID</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_incidents as $incident):
                                        $severityColors = [
                                            'low' => 'info',
                                            'medium' => 'warning',
                                            'high' => 'danger',
                                            'critical' => 'dark'
                                        ];
                                        $statusColors = [
                                            'reported' => 'warning',
                                            'investigating' => 'info',
                                            'resolved' => 'success',
                                            'closed' => 'secondary'
                                        ];
                                    ?>
                                        <tr>
                                            <td>#<?= esc($incident->incident_id); ?></td>
                                            <td><?= ucfirst(str_replace('_', ' ', esc($incident->incident_type))); ?></td>
                                            <td><?= date('M d, Y H:i', strtotime($incident->incident_date)); ?></td>
                                            <td>
                                                <span class="badge badge-<?= $severityColors[$incident->severity] ?? 'secondary'; ?>">
                                                    <?= ucfirst(esc($incident->severity)); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?= $statusColors[$incident->status] ?? 'secondary'; ?>">
                                                    <?= ucfirst(esc($incident->status)); ?>
                                                </span>
                                            </td>
                                            <td><?= esc($incident->customer_name ?? 'N/A'); ?></td>
                                            <td><?= $incident->order_id ? '#' . esc($incident->order_id) : 'N/A'; ?></td>
                                            <td><?= esc(substr($incident->description, 0, 60)) . (strlen($incident->description) > 60 ? '...' : ''); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->include('admin/footer'); ?>
