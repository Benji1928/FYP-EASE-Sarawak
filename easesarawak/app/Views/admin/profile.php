<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h2 class="fw-bold mb-3">My Profile</h2>
            </div>
        </div>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center">
                            <!-- Profile Picture -->
                            <div class="me-md-5 mb-4 mb-md-0">
                                <img
                                    src="<?= esc($user['profile_picture'] ? base_url($user['profile_picture']) : base_url('assets/images/user.png')) ?>"
                                    alt="Profile Picture"
                                    class="avatar-img rounded-circle"
                                    style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            </div>

                            <!-- User Details -->
                            <div class="flex-grow-1">
                                <h4 class="mb-3"><b><?= esc($user['username']) ?></b></h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-muted mb-1"><strong>Role:</strong></p>
                                        <p class="mb-3">
                                            <?php
                                            $role = $user['role'] == '1' ? 'Super Admin' : 'Admin';
                                            $badgeClass = $user['role'] == '1' ? 'badge-success' : 'badge-primary';
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= esc($role) ?></span>
                                        </p>

                                        <p class="text-muted mb-1"><strong>Email:</strong></p>
                                        <p class="mb-3"><?= esc($user['email']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-muted mb-1"><strong>Password:</strong></p>
                                        <p class="mb-3">••••••••</p>
                                    </div>
                                </div>

                                <!-- Edit Button -->
                                <div class="mt-4">
                                    <a href="<?= base_url('/edit_profile/' . $user['user_id']) ?>" class="btn btn-round" style="background: #f2be00df;">
                                        <i class="fas fa-edit"></i> Edit Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Optional: Additional Info Cards -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card card-round">
                    <div class="card-header">
                        <h5 class="card-title">Account Information</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><strong>User Since:</strong> <?= date('d M Y', strtotime($user['created_date'])) ?></li>
                            <li><strong>Account Status:</strong> <span class="badge badge-success">Active</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-round">
                    <div class="card-header">
                        <h5 class="card-title">Security</h5>
                    </div>
                    <div class="card-body">
                        <p>Keep your account secure by regularly updating your password.</p>
                        <a href="<?= base_url('/change_password') ?>" class="btn btn-round" style="background: #f2be00df;">
                            <i class="fas fa-key"></i> Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/footer'); ?>