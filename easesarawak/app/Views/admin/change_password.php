<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h2 class="fw-bold mb-3">Change Password</h2>
            </div>
            <div class="ms-md-auto">
                <a href="<?= base_url('/profile') ?>" class="btn btn-label-info btn-round">
                    <i class="fas fa-arrow-left"></i> Back to Profile
                </a>
            </div>
        </div>

        <!-- Success / Error Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card card-round">
                    <div class="card-header">
                        <h4 class="card-title">Update Your Password</h4>
                    </div>
                    <div class="card-body">
                        <?= form_open('change_password', ['id' => 'changePasswordForm']) ?>

                        <!-- Current Password -->
                        <div class="form-group">
                            <label for="current_password">Current Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="current_password"
                                    id="current_password"
                                    class="form-control"
                                    required>
                                <button type="button" class="btn btn-outline-secondary toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <?php if (isset($validation) && $validation->hasError('current_password')): ?>
                                <small class="text-danger"><?= $validation->getError('current_password') ?></small>
                            <?php endif; ?>
                        </div>

                        <!-- New Password -->
                        <div class="form-group">
                            <label for="new_password">New Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="new_password"
                                    id="new_password"
                                    class="form-control"
                                    required>
                                <button type="button" class="btn btn-outline-secondary toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <?php if (isset($validation) && $validation->hasError('new_password')): ?>
                                <small class="text-danger"><?= $validation->getError('new_password') ?></small>
                            <?php endif; ?>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="confirm_password"
                                    id="confirm_password"
                                    class="form-control"
                                    required>
                                <button type="button" class="btn btn-outline-secondary toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <?php if (isset($validation) && $validation->hasError('confirm_password')): ?>
                                <small class="text-danger"><?= $validation->getError('confirm_password') ?></small>
                            <?php endif; ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-end mt-4">
                            <button type="submit" class="btn btn-round" style="background: #f2be00df;">
                                <i class="fas fa-key"></i> Update Password
                            </button>
                        </div>

                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toggle Password Visibility -->
<script>
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });
</script>

<?= $this->include('admin/footer'); ?>