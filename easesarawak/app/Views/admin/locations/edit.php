<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3"><?= esc($title ?? 'Edit Location'); ?></h3>
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
                    <a href="<?= base_url('admin/locations'); ?>">Locations</a>
                </li>
                <li class="separator">
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="nav-item">Edit</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Location Information</h4>
                    </div>
                    <div class="card-body">
                        <?php if (session()->has('errors')): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session('errors') as $error): ?>
                                        <li><?= esc($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if (!isset($location) || empty($location)): ?>
                            <div class="alert alert-danger">
                                Location data not found. Please go back and try again.
                            </div>
                        <?php else: ?>
                        <form action="<?= base_url('admin/locations/update/' . (is_array($location) ? ($location['location_id'] ?? '') : ($location->location_id ?? ''))); ?>" method="post">
                            <?= csrf_field(); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Location Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               value="<?= esc(is_array($location) ? ($location['name'] ?? '') : ($location->name ?? '')); ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category <span class="text-danger">*</span></label>
                                        <select class="form-control" id="category" name="category" required>
                                            <option value="">Select Category</option>
                                            <?php $category = is_array($location) ? ($location['category'] ?? '') : ($location->category ?? ''); ?>
                                            <option value="Airport" <?= $category == 'Airport' ? 'selected' : ''; ?>>Airport</option>
                                            <option value="Hotel" <?= $category == 'Hotel' ? 'selected' : ''; ?>>Hotel</option>
                                            <option value="Shopping Mall" <?= $category == 'Shopping Mall' ? 'selected' : ''; ?>>Shopping Mall</option>
                                            <option value="Hub" <?= $category == 'Hub' ? 'selected' : ''; ?>>Storage Hub</option>
                                            <option value="Partner_Location" <?= $category == 'Partner_Location' ? 'selected' : ''; ?>>Partner Location</option>
                                            <option value="Other" <?= $category == 'Other' ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total_capacity">Storage Capacity (bags)</label>
                                        <input type="number" class="form-control" id="total_capacity"
                                               name="total_capacity" value="<?= esc(is_array($location) ? ($location['total_capacity'] ?? 0) : ($location->total_capacity ?? 0)); ?>">
                                        <small class="form-text text-muted">
                                            Current occupancy: <?= is_array($location) ? ($location['current_occupancy'] ?? 0) : ($location->current_occupancy ?? 0); ?> bags
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                               value="<?= esc(is_array($location) ? ($location['city'] ?? 'Kuching') : ($location->city ?? 'Kuching')); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control" id="state" name="state"
                                               value="<?= esc(is_array($location) ? ($location['state'] ?? 'Sarawak') : ($location->state ?? 'Sarawak')); ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="postcode">Postcode</label>
                                        <input type="text" class="form-control" id="postcode" name="postcode"
                                               value="<?= esc(is_array($location) ? ($location['postcode'] ?? '') : ($location->postcode ?? '')); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Full Address</label>
                                        <textarea class="form-control" id="address" name="address"
                                                  rows="3"><?= esc(is_array($location) ? ($location['address'] ?? '') : ($location->address ?? '')); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitude">Latitude</label>
                                        <input type="text" class="form-control" id="latitude" name="latitude"
                                               value="<?= esc(is_array($location) ? ($location['latitude'] ?? '') : ($location->latitude ?? '')); ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitude">Longitude</label>
                                        <input type="text" class="form-control" id="longitude" name="longitude"
                                               value="<?= esc(is_array($location) ? ($location['longitude'] ?? '') : ($location->longitude ?? '')); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active"
                                                   name="is_active" value="1" <?= (is_array($location) ? ($location['is_active'] ?? 0) : ($location->is_active ?? 0)) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="is_active">
                                                Active Location
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Location
                                </button>
                                <a href="<?= base_url('admin/locations'); ?>" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                                <?php 
                                $totalCapacity = is_array($location) ? ($location['total_capacity'] ?? 0) : ($location->total_capacity ?? 0);
                                $locId = is_array($location) ? ($location['location_id'] ?? '') : ($location->location_id ?? '');
                                if ($totalCapacity > 0): ?>
                                    <a href="<?= base_url('admin/locations/storage/' . $locId); ?>"
                                       class="btn btn-info">
                                        <i class="fa fa-boxes"></i> View Storage
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/footer'); ?>
