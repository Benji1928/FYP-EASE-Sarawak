<?= $this->include('admin/header'); ?>

<div class="container mt-5 pt-4">
    <div class="d-flex align-items-center mb-4" style="padding-top: 70px; padding-left: 20px;">
        <h3 class="fw-bold mb-0 me-3"><i class="fas fa-users me-2"></i>Staff Management</h3>
        <span class="text-muted">View all staff members and administrators</span>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Staff Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Employment Type</th>
                        <th>Created Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $index => $user): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($user['staff_name']) ?></td>
                                <td>
                                    <span class="badge <?php
                                        switch($user['role']) {
                                            case 'Superadmin': echo 'bg-danger'; break;
                                            case 'Admin': echo 'bg-primary'; break;
                                            case 'Driver': echo 'bg-info'; break;
                                            default: echo 'bg-secondary';
                                        }
                                    ?>">
                                        <?= esc($user['role']) ?>
                                    </span>
                                </td>
                                <td><?= esc($user['email'])?></td>
                                <td><?= esc(ucfirst(str_replace('_', ' ', $user['employment_type']))) ?></td>
                                <td><?= date('d M Y', strtotime($user['created_date'])) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/user/edit/' . $user['staff_id']); ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No staff members found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('admin/footer'); ?>