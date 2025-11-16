<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3"><?= esc($title ?? 'Add New Location'); ?></h3>
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
                <li class="nav-item">Add New</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Location Information</h4>
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

                        <form action="<?= base_url('admin/locations/store'); ?>" method="post">
                            <?= csrf_field(); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Location Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               value="<?= old('name'); ?>" placeholder="Enter location name" required>
                                        <small class="form-text text-muted">e.g., "Kuching International Airport", "Hilton Hotel"</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category <span class="text-danger">*</span></label>
                                        <select class="form-control" id="category" name="category" required>
                                            <option value="">Select Category</option>
                                            <option value="Airport" <?= old('category') == 'Airport' ? 'selected' : ''; ?>>Airport</option>
                                            <option value="Hotel" <?= old('category') == 'Hotel' ? 'selected' : ''; ?>>Hotel</option>
                                            <option value="Shopping Mall" <?= old('category') == 'Shopping Mall' ? 'selected' : ''; ?>>Shopping Mall</option>
                                            <option value="Hub" <?= old('category') == 'Hub' ? 'selected' : ''; ?>>Storage Hub</option>
                                            <option value="Partner_Location" <?= old('category') == 'Partner_Location' ? 'selected' : ''; ?>>Partner Location</option>
                                            <option value="Other" <?= old('category') == 'Other' ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total_capacity">Storage Capacity (bags)</label>
                                        <input type="number" class="form-control" id="total_capacity"
                                               name="total_capacity" value="<?= old('total_capacity', '0'); ?>"
                                               placeholder="Total storage capacity">
                                        <small class="form-text text-muted">Leave as 0 if location doesn't have storage</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                               value="<?= old('city', 'Kuching'); ?>" placeholder="City name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control" id="state" name="state"
                                               value="<?= old('state', 'Sarawak'); ?>" placeholder="State">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="postcode">Postcode</label>
                                        <input type="text" class="form-control" id="postcode" name="postcode"
                                               value="<?= old('postcode'); ?>" placeholder="Postcode">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Full Address <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="address" name="address"
                                                  rows="3" placeholder="Enter complete address" required><?= old('address'); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitude">Latitude</label>
                                        <input type="text" class="form-control" id="latitude" name="latitude"
                                               value="<?= old('latitude'); ?>" placeholder="e.g., 1.5535">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitude">Longitude</label>
                                        <input type="text" class="form-control" id="longitude" name="longitude"
                                               value="<?= old('longitude'); ?>" placeholder="e.g., 110.3593">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active"
                                                   name="is_active" value="1" <?= old('is_active', '1') ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="is_active">
                                                Active Location
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Create Location
                                </button>
                                <a href="<?= base_url('admin/locations'); ?>" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/footer'); ?>
