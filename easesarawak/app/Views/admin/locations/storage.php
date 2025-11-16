<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3"><?= esc($title ?? 'Location Storage Status'); ?></h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="<?= base_url('dashboard'); ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('locations'); ?>">Locations</a>
                </li>
                <li class="separator">
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="nav-item">Storage Status</li>
            </ul>
        </div>

        <!-- Location Info Card -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-map-marker-alt"></i> <?= esc(is_array($location) ? ($location['name'] ?? 'Unknown') : ($location->name ?? 'Unknown')); ?>
                            </h4>
                            <div class="ms-auto">
                                <?php $category = is_array($location) ? ($location['category'] ?? '') : ($location->category ?? ''); ?>
                                <span class="badge badge-<?= $category == 'Hub' ? 'primary' : 'info'; ?>">
                                    <?= esc($category); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <p><strong>Total Capacity:</strong><br>
                                    <?php $totalCapacity = is_array($location) ? ($location['total_capacity'] ?? 0) : ($location->total_capacity ?? 0); ?>
                                    <span class="h4"><?= number_format($totalCapacity); ?></span> bags
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Current Occupancy:</strong><br>
                                    <?php $currentOccupancy = is_array($location) ? ($location['current_occupancy'] ?? 0) : ($location->current_occupancy ?? 0); ?>
                                    <span class="h4 text-primary"><?= number_format($currentOccupancy); ?></span> bags
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Available Space:</strong><br>
                                    <span class="h4 text-success">
                                        <?= number_format($totalCapacity - $currentOccupancy); ?>
                                    </span> bags
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Occupancy Rate:</strong><br>
                                    <?php
                                    $capacity = $totalCapacity;
                                    $occupancy = $currentOccupancy;
                                    $rate = $capacity > 0 ? round(($occupancy / $capacity) * 100, 1) : 0;
                                    $badgeColor = 'success';
                                    if ($rate >= 90) $badgeColor = 'danger';
                                    elseif ($rate >= 75) $badgeColor = 'warning';
                                    elseif ($rate >= 50) $badgeColor = 'info';
                                    ?>
                                    <span class="badge badge-<?= $badgeColor; ?> h5">
                                        <?= number_format($rate, 1); ?>%
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="progress" style="height: 30px;">
                                    <div class="progress-bar bg-<?= $badgeColor; ?>" role="progressbar"
                                         style="width: <?= $rate; ?>%">
                                        <?= $occupancy; ?> / <?= $capacity; ?> bags
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <?php $locId = is_array($location) ? ($location['location_id'] ?? '') : ($location->location_id ?? ''); ?>
                                <a href="<?= base_url('locations/edit/' . $locId); ?>"
                                   class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i> Edit Location
                                </a>
                                <a href="<?= base_url('locations'); ?>" class="btn btn-secondary btn-sm">
                                    <i class="fa fa-arrow-left"></i> Back to Locations
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Storage Items Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fas fa-boxes"></i> Items Currently in Storage
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Tracking ID</th>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Bag Size</th>
                                        <th>Check-in Time</th>
                                        <th>Duration</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($storage_items)): ?>
                                        <?php foreach ($storage_items as $item): ?>
                                            <tr>
                                                <td><strong>#ST-<?= esc($item->tracking_id ?? 'N/A'); ?></strong></td>
                                                <td>
                                                    <a href="<?= base_url('orders/view/' . $item->order_id); ?>">
                                                        #<?= esc($item->order_id); ?>
                                                    </a>
                                                </td>
                                                <td><?= esc($item->first_name . ' ' . $item->last_name); ?></td>
                                                <td>
                                                    <span class="badge badge-secondary">
                                                        <?= esc($item->size ?? 'Standard'); ?>
                                                    </span>
                                                </td>
                                                <td><?= date('M d, Y H:i', strtotime($item->storage_start_time)); ?></td>
                                                <td>
                                                    <?php
                                                    $start = new DateTime($item->storage_start_time);
                                                    $now = new DateTime();
                                                    $diff = $start->diff($now);
                                                    $days = $diff->days;
                                                    $hours = $diff->h;

                                                    if ($days > 0) {
                                                        echo $days . ' day' . ($days > 1 ? 's' : '') . ' ' . $hours . 'h';
                                                    } else {
                                                        echo $hours . ' hour' . ($hours > 1 ? 's' : '');
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-warning">In Storage</span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('orders/view/' . $item->order_id); ?>"
                                                       class="btn btn-sm btn-info">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <div class="py-4">
                                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted mb-0">No items currently in storage at this location</p>
                                                </div>
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

        <!-- Storage Statistics -->
        <?php if (!empty($storage_items)): ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <i class="fas fa-boxes fa-2x mb-2"></i>
                                <h5>Total Items</h5>
                                <h3><?= count($storage_items); ?></h3>
                            </div>
                            <div class="col-md-3 text-center">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <h5>Avg Storage Time</h5>
                                <h3>
                                    <?php
                                    $totalHours = 0;
                                    foreach ($storage_items as $item) {
                                        $start = new DateTime($item->storage_start_time);
                                        $now = new DateTime();
                                        $diff = $start->diff($now);
                                        $totalHours += ($diff->days * 24) + $diff->h;
                                    }
                                    $avgHours = count($storage_items) > 0 ? round($totalHours / count($storage_items)) : 0;
                                    echo $avgHours . ' hrs';
                                    ?>
                                </h3>
                            </div>
                            <div class="col-md-3 text-center">
                                <i class="fas fa-percentage fa-2x mb-2"></i>
                                <h5>Utilization</h5>
                                <h3><?= number_format($rate, 1); ?>%</h3>
                            </div>
                            <div class="col-md-3 text-center">
                                <i class="fas fa-space-shuttle fa-2x mb-2"></i>
                                <h5>Free Space</h5>
                                <h3><?= number_format($totalCapacity - $currentOccupancy); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->include('admin/footer'); ?>
