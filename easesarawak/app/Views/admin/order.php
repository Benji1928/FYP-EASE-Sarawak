<?= $this->include('admin/header'); ?>

<div class="container mt-4">
    <div class="page-inner" style="padding-top: 80px;">
        <div class="d-flex align-items-center mb-4">
            <h3 class="fw-bold mb-0 me-3"><i class="fas fa-shopping-bag me-2"></i>Order Management</h3>
            <span class="text-muted">View all customer orders</span>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-softblue d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-white fw-semibold">Orders Overview</h5>
                <div class="input-group w-auto">
                    <input type="text" class="form-control form-control-sm" placeholder="Search orders..." id="orderSearch">
                    <button class="btn btn-light btn-sm"><i class="fa fa-search"></i></button>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle" id="orderTable">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Service Type</th>
                                <th>Customer Name</th>
                                <th>Contact Number</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= esc($order['order_id']); ?></td>
                                        <td><?= esc($order['service_type']); ?></td>
                                        <td><?= esc($order['first_name']); ?> <?= esc($order['last_name']); ?></td>
                                        <td><?= esc($order['phone']); ?></td>
                                        <td><?= date('d M Y, h:i A', strtotime($order['created_date'])); ?></td>
                                        <td>
                                            <a href="<?= base_url('/change_status/' . $order['order_id']); ?>"
                                                class="btn btn-sm 
                                                <?php
                                                    if ($order['status'] == 0) echo 'btn-warning';
                                                    elseif ($order['status'] == 1) echo 'btn-info';
                                                    else echo 'btn-success';
                                                ?>">
                                                <?php
                                                    if ($order['status'] == 0) echo '<i class="fa fa-hourglass-start"></i> Pending';
                                                    elseif ($order['status'] == 1) echo '<i class="fa fa-spinner"></i> In Progress';
                                                    else echo '<i class="fa fa-check"></i> Completed';
                                                ?>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/order/edit/' . $order['order_id']); ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No orders found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/footer'); ?>

<script>
    document.getElementById('orderSearch').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#orderTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>