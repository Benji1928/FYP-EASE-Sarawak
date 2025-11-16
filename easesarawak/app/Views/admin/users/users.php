<?= $this->include('admin/header'); ?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Users Management</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="<?= base_url('/admin'); ?>">
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
                            <li class="nav-item">Users</li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Customer List</h4>
                                        <a href="<?= base_url('/create_user'); ?>" class="btn btn-primary btn-round ms-auto">
                                            <i class="fa fa-plus"></i> Add User
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>User ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Customer Type</th>
                                                    <th>Status</th>
                                                    <th>Registered</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($users)): ?>
                                                    <?php foreach ($users as $user): ?>
                                                        <tr>
                                                            <td><?= esc($user['user_id']); ?></td>
                                                            <td><strong><?= esc($user['first_name'] . ' ' . $user['last_name']); ?></strong></td>
                                                            <td><?= esc($user['email']); ?></td>
                                                            <td><?= esc($user['phone'] ?? 'N/A'); ?></td>
                                                            <td><?= ucfirst(str_replace('_', ' ', esc($user['customer_type'] ?? 'standard'))); ?></td>
                                                            <td>
                                                                <?php if ($user['is_active']): ?>
                                                                    <span class="badge badge-success">Active</span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-secondary">Inactive</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= date('M d, Y', strtotime($user['created_date'])); ?></td>
                                                            <td class="text-center">
                                                                <a href="<?= base_url('admin/users/view/' . $user['user_id']); ?>" class="btn btn-sm btn-info">
                                                                    <i class="fa fa-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="8" class="text-center">No users found.</td>
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
