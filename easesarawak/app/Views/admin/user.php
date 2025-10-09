<?= $this->include('admin/header'); ?>

<div class="container mt-5 pt-4">
    <div class="d-flex align-items-center mb-4" style="padding-top: 70px; padding-left: 20px;">
        <h3 class="fw-bold mb-0 me-3"><i class="fas fa-users me-2"></i>User Management</h3>
        <span class="text-muted">View all registered users</span>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Created Date</th>
                        <th>Modified Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $index => $user): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($user['username']) ?></td>
                                <td><span class="badge bg-primary"><?= esc($user['role']) ?></span></td>
                                <td><?= esc($user['created_date']) ?></td>
                                <td>
                                    <?php if (!empty($user['modified_date'])): ?>
                                        <?= esc($user['modified_date']) ?></td>
                            <?php else: ?>
                                -
                            <?php endif ?>
                            <td class="text-center">
                                <a href="<?= base_url('admin/user/edit/' . $user['user_id']); ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"></i></a>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('admin/footer'); ?>