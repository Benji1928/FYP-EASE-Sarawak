<?= $this->include('admin/header'); ?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Locations Management</h3>
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
                                <a href="#">Management</a>
                            </li>
                            <li class="separator">
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="nav-item">Locations</li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Location List</h4>
                                        <a href="<?= base_url('locations/create'); ?>" class="btn btn-primary btn-round ms-auto">
                                            <i class="fa fa-plus"></i> Add Location
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Location Name</th>
                                                    <th>Category</th>
                                                    <th>Address</th>
                                                    <th>Capacity</th>
                                                    <th>Occupancy</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($locations)): ?>
                                                    <?php foreach ($locations as $location): ?>
                                                        <tr>
                                                            <td><?= esc($location['location_id']); ?></td>
                                                            <td><strong><?= esc($location['location_name']); ?></strong></td>
                                                            <td><?= ucfirst(esc($location['category'])); ?></td>
                                                            <td>
                                                                <?= esc($location['address']); ?><br>
                                                                <small class="text-muted">
                                                                    <?php
                                                                    $cityState = array_filter([
                                                                        $location['city'] ?? '',
                                                                        $location['state'] ?? ''
                                                                    ]);
                                                                    echo esc(implode(', ', $cityState));
                                                                    ?>
                                                                </small>
                                                            </td>
                                                            <td><?= number_format($location['total_capacity'] ?? 0); ?></td>
                                                            <td>
                                                                <?php
                                                                $occupancy = $location['current_occupancy'] ?? 0;
                                                                $capacity = $location['total_capacity'] ?? 1;
                                                                $percentage = $capacity > 0 ? round(($occupancy / $capacity) * 100, 1) : 0;
                                                                $colorClass = $percentage > 80 ? 'danger' : ($percentage > 60 ? 'warning' : 'success');
                                                                ?>
                                                                <span class="badge badge-<?= $colorClass; ?>"><?= $occupancy; ?> / <?= $capacity; ?> (<?= $percentage; ?>%)</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="<?= base_url('locations/edit/' . $location['location_id']); ?>" class="btn btn-sm btn-warning">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                                <a href="<?= base_url('locations/storage/' . $location['location_id']); ?>" class="btn btn-sm btn-info">
                                                                    <i class="fa fa-warehouse"></i> Storage
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="7" class="text-center">No locations found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <?php if (isset($pager)): ?>
                                        <div class="mt-3">
                                            <?= $pager->links(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?= $this->include('admin/footer'); ?>
