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
                                            <button type="button" class="btn btn-sm btn-outline-primary viewOrderBtn"
                                                data-id="<?= $order['order_id']; ?>">
                                                <i class="fa fa-eye"></i>
                                            </button>
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

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-softblue text-white">
                <h5 class="modal-title fw-semibold" id="orderModalLabel">
                    <i class="fa fa-file-alt me-2"></i>Order Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="orderDetailsContent" class="text-center py-3 text-muted">
                    <i class="fa fa-spinner fa-spin me-2"></i>Loading...
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i>Close
                </button>
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

    document.querySelectorAll('.viewOrderBtn').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-id');
            const modal = new bootstrap.Modal(document.getElementById('orderModal'));
            const contentDiv = document.getElementById('orderDetailsContent');

            contentDiv.innerHTML = `
            <div class="text-center py-4 text-muted">
                <i class="fa fa-spinner fa-spin me-2"></i>Loading order details...
            </div>`;
            modal.show();

            fetch(`<?= base_url('/order/getDetails'); ?>/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const o = data.order;
                        contentDiv.innerHTML = `
                        <div class="container-fluid">
                            <!-- Section 1 -->
                            <div class="card border-0 shadow-sm mb-3 rounded-3">
                                <div class="card-header bg-light fw-semibold">
                                    <i class="fa fa-user me-2 text-primary"></i>Customer Information
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <p><strong>First Name:</strong> ${o.first_name}</p>
                                            <p><strong>Last Name:</strong> ${o.last_name}</p>
                                            <p><strong>Email:</strong> ${o.email}</p>
                                            <p><strong>Phone:</strong> ${o.phone}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>ID Number:</strong> ${o.id_num}</p>
                                            <p><strong>Social:</strong> ${o.social}</p>
                                            <p><strong>Social Number:</strong> ${o.social_num}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2 -->
                            <div class="card border-0 shadow-sm mb-3 rounded-3">
                                <div class="card-header bg-light fw-semibold">
                                    <i class="fa fa-briefcase me-2 text-primary"></i>Order Information
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <p><strong>Service Type:</strong> ${o.service_type}</p>
                                            <p><strong>Special:</strong> ${o.special}</p>
                                            <p><strong>Special Note:</strong> ${o.special_note || '-'}</p>
                                            <p><strong>Promo Code:</strong> ${o.promo_code || '-'}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Status:</strong> ${
                                                o.status == 0
                                                    ? '<span class="badge bg-warning text-dark">Pending</span>'
                                                    : o.status == 1
                                                    ? '<span class="badge bg-info text-dark">In Progress</span>'
                                                    : '<span class="badge bg-success">Completed</span>'
                                            }</p>
                                            <p><strong>Amount:</strong> RM${o.amount}</p>
                                            <p><strong>Payment Method:</strong> ${o.payment_method}</p>
                                            <p><strong>Upload:</strong> ${
                                                o.upload
                                                    ? `<a href="<?= base_url('uploads/'); ?>${o.upload}" target="_blank" class="text-decoration-none text-primary">View File</a>`
                                                    : 'No file uploaded'
                                            }</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3 -->
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-header bg-light fw-semibold">
                                    <i class="fa fa-database me-2 text-primary"></i>Order Details
                                </div>
                                <div class="card-body">
                                    <pre class="bg-light p-3 rounded" style="font-size: 0.9rem; white-space: pre-wrap;">${o.order_details_json}</pre>
                                </div>
                            </div>
                        </div>
                    `;
                    } else {
                        contentDiv.innerHTML = `<div class="text-danger text-center py-4">${data.message}</div>`;
                    }
                })
                .catch(() => {
                    contentDiv.innerHTML = `<div class="text-danger text-center py-4">Error loading order details.</div>`;
                });
        });
    });
</script>