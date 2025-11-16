<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3"><?= esc($title ?? 'Edit Partner'); ?></h3>
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
                    <a href="<?= base_url('partners'); ?>">Partners</a>
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
                        <h4 class="card-title">Edit Partner Information</h4>
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

                        <?php if (!isset($partner) || empty($partner)): ?>
                            <div class="alert alert-danger">
                                Partner data not found. Please go back and try again.
                            </div>
                        <?php else: ?>
                        <form action="<?= base_url('partners/update/' . (is_array($partner) ? $partner['partner_id'] : $partner->partner_id)); ?>" method="post">
                            <?= csrf_field(); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="partner_name">Partner Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="partner_name" name="partner_name"
                                               value="<?= esc(is_array($partner) ? ($partner['partner_name'] ?? '') : ($partner->partner_name ?? '')); ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Partner Type <span class="text-danger">*</span></label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="">Select Type</option>
                                            <?php $type = is_array($partner) ? $partner['type'] : $partner->type; ?>
                                            <option value="Hotel" <?= $type == 'Hotel' ? 'selected' : ''; ?>>Hotel</option>
                                            <option value="Airbnb" <?= $type == 'Airbnb' ? 'selected' : ''; ?>>Airbnb</option>
                                            <option value="TourAgency" <?= $type == 'TourAgency' ? 'selected' : ''; ?>>Tour Agency</option>
                                            <option value="Event" <?= $type == 'Event' ? 'selected' : ''; ?>>Event Organizer</option>
                                            <option value="Airline" <?= $type == 'Airline' ? 'selected' : ''; ?>>Airline</option>
                                            <option value="Travel_Agency" <?= $type == 'Travel_Agency' ? 'selected' : ''; ?>>Travel Agency</option>
                                            <option value="Other" <?= $type == 'Other' ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="commission_rate">Commission Rate (%) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control" id="commission_rate"
                                               name="commission_rate" value="<?= esc(is_array($partner) ? $partner['commission_rate'] : $partner->commission_rate); ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_person">Contact Person</label>
                                        <input type="text" class="form-control" id="contact_person" name="contact_person"
                                               value="<?= esc(is_array($partner) ? ($partner['contact_person'] ?? '') : ($partner->contact_person ?? '')); ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_email">Contact Email</label>
                                        <input type="email" class="form-control" id="contact_email" name="contact_email"
                                               value="<?= esc(is_array($partner) ? ($partner['contact_email'] ?? '') : ($partner->contact_email ?? '')); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_phone">Contact Phone</label>
                                        <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                                               value="<?= esc(is_array($partner) ? ($partner['contact_phone'] ?? '') : ($partner->contact_phone ?? '')); ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contract_start_date">Contract Start Date</label>
                                        <input type="date" class="form-control" id="contract_start_date"
                                               name="contract_start_date" value="<?= esc(is_array($partner) ? ($partner['contract_start_date'] ?? '') : ($partner->contract_start_date ?? '')); ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contract_end_date">Contract End Date</label>
                                        <input type="date" class="form-control" id="contract_end_date"
                                               name="contract_end_date" value="<?= esc(is_array($partner) ? ($partner['contract_end_date'] ?? '') : ($partner->contract_end_date ?? '')); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="payment_terms">Payment Terms</label>
                                        <textarea class="form-control" id="payment_terms" name="payment_terms"
                                                  rows="3"><?= esc(is_array($partner) ? ($partner['payment_terms'] ?? '') : ($partner->payment_terms ?? '')); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control" id="address" name="address"
                                                  rows="3"><?= esc(is_array($partner) ? ($partner['address'] ?? '') : ($partner->address ?? '')); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active"
                                                   name="is_active" value="1" <?= (is_array($partner) ? $partner['is_active'] : $partner->is_active) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="is_active">
                                                Active Partner
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Partner
                                </button>
                                <a href="<?= base_url('partners'); ?>" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                                <a href="<?= base_url('partners/performance/' . (is_array($partner) ? $partner['partner_id'] : $partner->partner_id)); ?>"
                                   class="btn btn-info">
                                    <i class="fa fa-chart-line"></i> View Performance
                                </a>
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
