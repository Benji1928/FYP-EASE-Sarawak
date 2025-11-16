<?= $this->include('admin/header'); ?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Partners Management</h3>
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
                            <li class="nav-item">Partners</li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Partner List</h4>
                                        <a href="<?= base_url('admin/partners/create'); ?>" class="btn btn-primary btn-round ms-auto">
                                            <i class="fa fa-plus"></i> Add Partner
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Partner Name</th>
                                                    <th>Type</th>
                                                    <th>Contact</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($partners)): ?>
                                                    <?php foreach ($partners as $partner): ?>
                                                        <tr>
                                                            <td><?= esc($partner['partner_id']); ?></td>
                                                            <td><strong><?= esc($partner['partner_name']); ?></strong></td>
                                                            <td><?= ucfirst(esc($partner['type'])); ?></td>
                                                            <td>
                                                                <?= esc($partner['contact_person'] ?? 'N/A'); ?><br>
                                                                <small class="text-muted"><?= esc($partner['contact_email'] ?? ''); ?></small>
                                                            </td>
                                                            <td>
                                                                <?php if ($partner['is_active']): ?>
                                                                    <span class="badge badge-success">Active</span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-secondary">Inactive</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="<?= base_url('admin/partners/edit/' . $partner['partner_id']); ?>" class="btn btn-sm btn-warning">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                                <a href="<?= base_url('admin/partners/performance/' . $partner['partner_id']); ?>" class="btn btn-sm btn-info">
                                                                    <i class="fa fa-chart-line"></i> Performance
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">No partners found.</td>
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
