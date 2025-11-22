<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h2 class="fw-bold mb-3">Edit Profile</h2>
            </div>
            <div class="ms-md-auto">
                <a href="<?= base_url('/profile') ?>" class="btn btn-label-info btn-round">
                    <i class="fas fa-arrow-left"></i> Back to Profile
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card card-round">
                    <div class="card-header">
                        <h4 class="card-title">Update Your Information</h4>
                    </div>
                    <div class="card-body">
                        <?= form_open_multipart('update_profile/' . $user['user_id'], ['id' => 'editProfileForm']) ?>

                        <!-- Profile Picture -->
                        <div class="text-center mb-4">
                            <img
                                src="<?= esc($user['profile_picture'] ? base_url($user['profile_picture']) : base_url('assets/images/user.png')) ?>?>"
                                alt="Profile Picture"
                                id="profilePreview"
                                class="avatar-img rounded-circle"
                                style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            <div class="mt-3">
                                <label for="profile_picture" class="btn btn-sm btn-round" style="background: #f2be00df;">
                                    <i class="fas fa-camera"></i> Change Photo
                                </label>
                                <input
                                    type="file"
                                    name="profile_picture"
                                    id="profile_picture"
                                    class="d-none"
                                    accept="image/*"
                                    onchange="previewImage(event)">
                            </div>
                            <small class="text-muted d-block mt-1">Max size: 2MB (JPG, PNG)</small>
                        </div>

                        <hr>

                        <!-- Username -->
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="username"
                                id="username"
                                class="form-control"
                                value="<?= esc(old('username', $user['username'])) ?>"
                                required>
                            <?php if (isset($validation) && $validation->hasError('username')): ?>
                                <small class="text-danger"><?= $validation->getError('username') ?></small>
                            <?php endif; ?>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                value="<?= esc(old('email', $user['email'])) ?>"
                                required>
                            <?php if (isset($validation) && $validation->hasError('email')): ?>
                                <small class="text-danger"><?= $validation->getError('email') ?></small>
                            <?php endif; ?>
                        </div>

                        <!-- Role (Read-only unless Super Admin) -->
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input
                                type="text"
                                class="form-control"
                                value="<?= $user['role'] == '1' ? 'Super Admin' : 'Admin' ?>"
                                disabled>
                            <input type="hidden" name="role" value="<?= esc($user['role']) ?>">
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-round" style="background: #f2be00df;">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>

                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Script -->
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profilePreview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<?= $this->include('admin/footer'); ?>