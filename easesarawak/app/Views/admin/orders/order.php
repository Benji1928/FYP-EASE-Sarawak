<?= $this->include('admin/header'); ?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Orders Management</h3>
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
                            <li class="nav-item">Orders</li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="card-title mb-0">Order List</h4>
                                        <div class="input-group" style="width: 300px;">
                                            <input type="text" class="form-control form-control-sm" placeholder="Search orders..." id="orderSearch">
                                            <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" id="orderTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer</th>
                                                    <th>Service Type</th>
                                                    <th>Order Date</th>
                                                    <th>Status</th>
                                                    <th>Amount</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($orders)): ?>
                                                    <?php foreach ($orders as $order): ?>
                                                        <tr>
                                                            <td><strong>#<?= esc($order['order_id']); ?></strong></td>
                                                            <td>
                                                                <?= esc($order['first_name'] ?? ''); ?> <?= esc($order['last_name'] ?? ''); ?><br>
                                                                <small class="text-muted"><?= esc($order['email'] ?? ''); ?></small>
                                                            </td>
                                                            <td><?= ucfirst(str_replace('_', ' ', esc($order['service_type']))); ?></td>
                                                            <td><?= date('M d, Y', strtotime($order['created_date'])); ?></td>
                                                            <td>
                                                                <select class="form-select form-select-sm status-select"
                                                                    data-order-id="<?= $order['order_id']; ?>"
                                                                    style="width: auto; min-width: 150px;">
                                                                    <option value="Pending" <?= $order['order_status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                                    <option value="Confirmed" <?= $order['order_status'] === 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                                                    <option value="In_Storage" <?= $order['order_status'] === 'In_Storage' ? 'selected' : ''; ?>>In Storage</option>
                                                                    <option value="Out-for-Delivery" <?= $order['order_status'] === 'Out-for-Delivery' ? 'selected' : ''; ?>>Out for Delivery</option>
                                                                    <option value="Completed" <?= $order['order_status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                                                    <option value="Cancelled" <?= $order['order_status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                                </select>
                                                            </td>
                                                            <td><strong>RM <?= number_format($order['total_amount'], 2); ?></strong></td>
                                                            <td class="text-center">
                                                                <a href="<?= base_url('admin/orders/view/' . $order['order_id']); ?>" class="btn btn-sm btn-info">
                                                                    <i class="fa fa-eye"></i> View
                                                                </a>
                                                                <button class="btn btn-sm btn-warning btn-add-note"
                                                                    data-id="<?= $order['order_id']; ?>"
                                                                    data-note="<?= htmlspecialchars($order['special_note'] ?? '', ENT_QUOTES); ?>"
                                                                    title="Add/Edit Note">
                                                                    <i class="fa fa-sticky-note"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="7" class="text-center">No orders found.</td>
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

<!-- Add Note Modal -->
<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noteModalLabel">Add/Edit Special Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="noteForm">
                    <input type="hidden" name="order_id" id="noteOrderId">
                    <div class="form-group">
                        <label for="orderNote">Special Note</label>
                        <textarea class="form-control" id="orderNote" name="note" rows="4" placeholder="Write your note here..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="saveNoteBtn" class="btn btn-primary">Save Note</button>
            </div>
        </div>
    </div>
</div>

<!-- Cancellation Reason Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancellation Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cancelForm">
                    <input type="hidden" name="order_id" id="cancelOrderId">
                    <div class="form-group">
                        <label for="cancellationReason">Please provide a reason for cancellation <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="cancellationReason" name="cancellation_reason" rows="4" placeholder="Enter cancellation reason..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmCancelBtn" class="btn btn-danger">Confirm Cancellation</button>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/footer'); ?>

<script>
    // Search functionality
    document.getElementById('orderSearch').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#orderTable tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Add/Edit Note functionality
    document.querySelectorAll('.btn-add-note').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-id');
            const note = this.getAttribute('data-note');

            document.getElementById('noteOrderId').value = orderId;
            document.getElementById('orderNote').value = note;

            const noteModal = new bootstrap.Modal(document.getElementById('noteModal'));
            noteModal.show();
        });
    });

    // Save note
    document.getElementById('saveNoteBtn').addEventListener('click', function() {
        const orderId = document.getElementById('noteOrderId').value;
        const note = document.getElementById('orderNote').value;

        // Get CSRF token
        const csrfName = '<?= csrf_token(); ?>';
        const csrfHash = '<?= csrf_hash(); ?>';

        // Using fetch API instead of jQuery
        fetch('<?= base_url("/save_note"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: csrfName + '=' + encodeURIComponent(csrfHash) + '&order_id=' + encodeURIComponent(orderId) + '&note=' + encodeURIComponent(note)
        })
        .then(response => response.json())
        .then(data => {
            const noteModal = bootstrap.Modal.getInstance(document.getElementById('noteModal'));
            noteModal.hide();

            if (data.success) {
                // Show success message
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Note Saved!',
                        text: 'The special note has been successfully saved.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    alert('Note saved successfully!');
                    location.reload();
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Unable to save note. Please try again.'
                    });
                } else {
                    alert('Error saving note. Please try again.');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Unable to save note. Please try again.'
                });
            } else {
                alert('Error saving note. Please try again.');
            }
        });
    });

    // Status change handling
    let previousStatus = {};
    document.querySelectorAll('.status-select').forEach(select => {
        const orderId = select.getAttribute('data-order-id');
        previousStatus[orderId] = select.value;

        select.addEventListener('change', function() {
            const newStatus = this.value;
            const orderId = this.getAttribute('data-order-id');

            if (newStatus === 'Cancelled') {
                // Show cancellation reason modal
                document.getElementById('cancelOrderId').value = orderId;
                document.getElementById('cancellationReason').value = '';
                const cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
                cancelModal.show();

                // Store the select element for later use
                window.currentStatusSelect = this;
            } else {
                // Confirm status change
                const confirmMessage = 'Are you sure you want to change the order status to "' + newStatus.replace('_', ' ') + '"?';

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Confirm Status Change',
                        text: confirmMessage,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, update it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            updateOrderStatus(orderId, newStatus);
                        } else {
                            // Revert to previous status
                            this.value = previousStatus[orderId];
                        }
                    });
                } else {
                    if (confirm(confirmMessage)) {
                        updateOrderStatus(orderId, newStatus);
                    } else {
                        // Revert to previous status
                        this.value = previousStatus[orderId];
                    }
                }
            }
        });
    });

    // Confirm cancellation with reason
    document.getElementById('confirmCancelBtn').addEventListener('click', function() {
        const orderId = document.getElementById('cancelOrderId').value;
        const reason = document.getElementById('cancellationReason').value.trim();

        if (!reason) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Required',
                    text: 'Please provide a cancellation reason.'
                });
            } else {
                alert('Please provide a cancellation reason.');
            }
            return;
        }

        const cancelModal = bootstrap.Modal.getInstance(document.getElementById('cancelModal'));
        cancelModal.hide();

        updateOrderStatus(orderId, 'Cancelled', reason);
    });

    // Handle modal cancel - revert status
    document.getElementById('cancelModal').addEventListener('hidden.bs.modal', function() {
        if (window.currentStatusSelect && window.currentStatusSelect.value === 'Cancelled') {
            const orderId = window.currentStatusSelect.getAttribute('data-order-id');
            window.currentStatusSelect.value = previousStatus[orderId];
        }
    });

    // Function to update order status
    function updateOrderStatus(orderId, status, cancellationReason = '') {
        // Get CSRF token
        const csrfName = '<?= csrf_token(); ?>';
        const csrfHash = '<?= csrf_hash(); ?>';

        // Prepare form data
        const formData = new URLSearchParams();
        formData.append(csrfName, csrfHash);
        formData.append('order_status', status);
        if (cancellationReason) {
            formData.append('cancellation_reason', cancellationReason);
        }

        // Show loading state
        const selectElement = document.querySelector(`.status-select[data-order-id="${orderId}"]`);
        const originalValue = selectElement.value;
        selectElement.disabled = true;

        // Make AJAX request
        fetch('<?= base_url("admin/orders/update-status/"); ?>' + orderId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData.toString()
        })
        .then(response => {
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            }
            // If redirected or HTML response, treat as success (fallback for non-AJAX)
            if (response.ok || response.redirected) {
                return { success: true };
            }
            // If not OK, return error
            return { success: false, message: 'Failed to update status' };
        })
        .then(data => {
            selectElement.disabled = false;
            
            if (data.success) {
                // Show success message
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message || 'Order status updated successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    alert('Order status updated successfully!');
                    location.reload();
                }
            } else {
                // Revert to previous status
                selectElement.value = originalValue;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error updating status. Please try again.'
                    });
                } else {
                    alert('Error updating status. Please try again.');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            selectElement.disabled = false;
            selectElement.value = originalValue;
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating status. Please try again.'
                });
            } else {
                alert('Error updating status. Please try again.');
            }
        });
    }
</script>
