<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3"><?= esc($title ?? 'Add New Partner'); ?></h3>
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
                <li class="nav-item">Add New</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Partner Information</h4>
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

                        <form action="<?= base_url('partners/store'); ?>" method="post">
                            <?= csrf_field(); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="partner_name">Partner Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="partner_name" name="partner_name"
                                               value="<?= old('partner_name'); ?>" placeholder="Enter partner name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Partner Type <span class="text-danger">*</span></label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="">Select Type</option>
                                            <option value="Hotel" <?= old('type') == 'Hotel' ? 'selected' : ''; ?>>Hotel</option>
                                            <option value="Airbnb" <?= old('type') == 'Airbnb' ? 'selected' : ''; ?>>Airbnb</option>
                                            <option value="TourAgency" <?= old('type') == 'TourAgency' ? 'selected' : ''; ?>>Tour Agency</option>
                                            <option value="Event" <?= old('type') == 'Event' ? 'selected' : ''; ?>>Event Organizer</option>
                                            <option value="Airline" <?= old('type') == 'Airline' ? 'selected' : ''; ?>>Airline</option>
                                            <option value="Travel_Agency" <?= old('type') == 'Travel_Agency' ? 'selected' : ''; ?>>Travel Agency</option>
                                            <option value="Other" <?= old('type') == 'Other' ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="commission_rate">Commission Rate (%) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control" id="commission_rate"
                                               name="commission_rate" value="<?= old('commission_rate', '0.00'); ?>"
                                               placeholder="e.g., 10.00" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_person">Contact Person</label>
                                        <input type="text" class="form-control" id="contact_person" name="contact_person"
                                               value="<?= old('contact_person'); ?>" placeholder="Contact person name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_email">Contact Email</label>
                                        <input type="email" class="form-control" id="contact_email" name="contact_email"
                                               value="<?= old('contact_email'); ?>" placeholder="email@example.com">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_phone">Contact Phone</label>
                                        <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                                               value="<?= old('contact_phone'); ?>" placeholder="+60 12-345 6789">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contract_start_date">Contract Start Date</label>
                                        <input type="date" class="form-control" id="contract_start_date"
                                               name="contract_start_date" value="<?= old('contract_start_date'); ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contract_end_date">Contract End Date</label>
                                        <input type="date" class="form-control" id="contract_end_date"
                                               name="contract_end_date" value="<?= old('contract_end_date'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="payment_terms">Payment Terms</label>
                                        <textarea class="form-control" id="payment_terms" name="payment_terms"
                                                  rows="3" placeholder="Enter payment terms and conditions"><?= old('payment_terms'); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control" id="address" name="address"
                                                  rows="3" placeholder="Enter complete address"><?= old('address'); ?></textarea>
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
                                                Active Partner
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Create Partner
                                </button>
                                <a href="<?= base_url('partners'); ?>" class="btn btn-secondary">
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
