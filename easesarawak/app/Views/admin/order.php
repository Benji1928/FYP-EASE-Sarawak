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
                                                switch ($order['order_status']) {
                                                    case 'Pending': echo 'btn-warning'; break;
                                                    case 'Confirmed': echo 'btn-primary'; break;
                                                    case 'In_Storage': echo 'btn-info'; break;
                                                    case 'Out-for-Delivery': echo 'btn-secondary'; break;
                                                    case 'Completed': echo 'btn-success'; break;
                                                    default: echo 'btn-secondary';
                                                }
                                                ?>">
                                                <i class="fa fa-circle me-1"></i><?= esc(str_replace('_', ' ', $order['order_status'])); ?>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex align-items-center">
                                                <button type="button" class="btn btn-sm viewOrderBtn me-2"
                                                    data-id="<?= $order['order_id']; ?>"
                                                    style="background: #f2be00">
                                                    <i class="fa fa-eye"></i>
                                                </button>

                                                <button class="btn btn-sm btn-dark btn-add-note"
                                                    data-id="<?= $order['order_id']; ?>"
                                                    data-note="<?= htmlspecialchars($order['special_note'] ?? '', ENT_QUOTES); ?>">
                                                    <i class="fa fa-sticky-note"></i>
                                                </button>
                                            </div>
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
<!-- Add Note Modal -->
<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-softblue text-white">
                <h5 class="modal-title" id="noteModalLabel">Add Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="noteForm">
                    <input type="hidden" name="order_id" id="noteOrderId">
                    <div class="form-group">
                        <label for="orderNote">Note</label>
                        <textarea class="form-control" id="orderNote" name="note" rows="4" placeholder="Write your note here..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="saveNoteBtn" class="btn btn-softblue">Save</button>
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
                                            <p><strong>Nationality:</strong> ${o.nationality || 'N/A'}</p>
                                            <p><strong>Social:</strong> ${o.social || 'N/A'}</p>
                                            <p><strong>Social Number:</strong> ${o.social_num || 'N/A'}</p>
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
                                            <p><strong>Last Modified:</strong> ${o.modified_date || '-'}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Status:</strong> <span class="badge bg-primary">${o.order_status || 'N/A'}</span></p>
                                            <p><strong>Amount:</strong> RM${o.total_amount || '0.00'}</p>
                                            <p><strong>Payment ID:</strong> ${o.payment_id || 'N/A'}</p>
                                            <p><strong>Dropoff Time:</strong> ${o.dropoff_time || 'N/A'}</p>
                                            <p><strong>Pickup Time:</strong> ${o.pickup_time || 'N/A'}</p>
                                            <p><strong>Modified By:</strong> ${o.modified_by_name || 'System'}</p>
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

                            <!-- Section 4 -->
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-header bg-light fw-semibold">
                                    <i class="fa fa-comment me-2 text-primary"></i>Special Note
                                </div>
                                <div class="card-body">
                                    <pre class="bg-light p-3 rounded" style="font-size: 0.9rem; white-space: pre-wrap;">${o.special_note || 'No special notes'}</pre>
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

    $(document).ready(function() {
        // Show modal with existing note if any
        $('.btn-add-note').on('click', function() {
            const orderId = $(this).data('id');
            const note = $(this).data('note');
            $('#noteOrderId').val(orderId);
            $('#orderNote').val(note);
            $('#noteModal').modal('show');
        });

        // Save note via AJAX
        $('#saveNoteBtn').on('click', function() {
            const orderId = $('#noteOrderId').val();
            const note = $('#orderNote').val();

            $.ajax({
                url: '<?= base_url("/save_note") ?>',
                type: 'POST',
                data: {
                    order_id: orderId,
                    note: note
                },
                success: function(response) {
                    $('#noteModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Note Saved!',
                        text: 'Your note has been successfully saved.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Unable to save note. Please try again.'
                    });
                }
            });
        });
    });
</script>