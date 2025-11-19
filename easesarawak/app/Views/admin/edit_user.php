<?= $this->include('admin/header'); ?>

<div class="container mt-5 pt-4">
    <div class="d-flex align-items-center mb-4" style="padding-top: 70px; padding-left: 40px;">
        <h3 class="fw-bold mb-0 me-3"><i class="fas fa-user-edit me-2"></i>Edit User</h3>
        <span class="text-muted">Update user information</span>
    </div>
    <!-- Feedback messages -->
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-info text-center"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger text-center"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm" style="margin: 20px;">
        <div class="card-body">
            <form action="<?= base_url('/update_user/' . $user['user_id']); ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= esc(old('username', $user['username'])) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= esc(old('email', $user['email'])) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="0" <?= $user['role'] == 0 ? 'selected' : '' ?>>Admin</option>
                        <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Superadmin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Update</button>
                <a href="<?= base_url('/user') ?>" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?= $this->include('admin/footer'); ?>