<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Order Details</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="<?= base_url('/dashboard'); ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('orders'); ?>">Orders</a>
                </li>
                <li class="separator">
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="nav-item">Order #<?= esc($order->order_id); ?></li>
            </ul>
        </div>

        <div class="row">
            <!-- Order Information -->
            <div class="col-md-8">
                <!-- Order Header Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Order #<?= esc($order->order_id); ?></h4>
                            <div>
                                <?php
                                $statusColors = [
                                    'Pending' => 'warning',
                                    'Confirmed' => 'info',
                                    'In_Storage' => 'primary',
                                    'Out-for-Delivery' => 'secondary',
                                    'Completed' => 'success',
                                    'Cancelled' => 'danger'
                                ];
                                $color = $statusColors[$order->order_status] ?? 'secondary';
                                ?>
                                <span class="badge badge-<?= $color; ?> badge-lg"><?= str_replace('_', ' ', esc($order->order_status)); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Service Type:</strong> <?= ucfirst(str_replace('_', ' ', esc($order->service_type))); ?></p>
                                <p><strong>Created Date:</strong> <?= date('M d, Y h:i A', strtotime($order->created_date)); ?></p>
                                <?php if (isset($order->pickup_date)): ?>
                                    <p><strong>Pickup Date:</strong> <?= date('M d, Y h:i A', strtotime($order->pickup_date)); ?></p>
                                <?php endif; ?>
                                <?php if (isset($order->dropoff_date)): ?>
                                    <p><strong>Dropoff Date:</strong> <?= date('M d, Y h:i A', strtotime($order->dropoff_date)); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Total Amount:</strong> <span class="text-success fw-bold">RM <?= number_format($order->total_amount, 2); ?></span></p>
                                <?php if (isset($order->partner_name) && $order->partner_name): ?>
                                    <p><strong>Partner:</strong> <?= esc($order->partner_name); ?></p>
                                <?php endif; ?>
                                <?php if ($order->is_cancelled): ?>
                                    <p><strong>Cancellation Reason:</strong> <span class="text-danger"><?= esc($order->cancellation_reason ?? 'N/A'); ?></span></p>
                                    <p><strong>Cancelled At:</strong> <?= $order->cancellation_time ? date('M d, Y h:i A', strtotime($order->cancellation_time)) : 'N/A'; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Order Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Additional Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?php if (isset($order->special)): ?>
                                    <p><strong>Special:</strong> <?= esc($order->special); ?></p>
                                <?php endif; ?>
                                <?php if (isset($order->promo_code) && $order->promo_code): ?>
                                    <p><strong>Promo Code:</strong> <span class="badge badge-success"><?= esc($order->promo_code); ?></span></p>
                                <?php endif; ?>
                                <?php if (isset($order->pickup_time)): ?>
                                    <p><strong>Pickup Time:</strong> <?= esc($order->pickup_time); ?></p>
                                <?php endif; ?>
                                <?php if (isset($order->dropoff_time)): ?>
                                    <p><strong>Dropoff Time:</strong> <?= esc($order->dropoff_time); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <?php if (isset($order->modified_date)): ?>
                                    <p><strong>Last Modified:</strong> <?= date('M d, Y h:i A', strtotime($order->modified_date)); ?></p>
                                <?php endif; ?>
                                <?php if (isset($order->modified_by_name)): ?>
                                    <p><strong>Modified By:</strong> <?= esc($order->modified_by_name); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (isset($order->special_note) && $order->special_note): ?>
                            <hr>
                            <div class="mt-3">
                                <p><strong>Special Note:</strong></p>
                                <div class="alert alert-info">
                                    <?= nl2br(esc($order->special_note)); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($order->order_details_json) && $order->order_details_json): ?>
                            <hr>
                            <div class="mt-3">
                                <p><strong>Order Details (JSON):</strong></p>
                                <pre class="bg-light p-3 rounded" style="font-size: 0.85rem; max-height: 300px; overflow-y: auto;"><?php
                                    $jsonData = json_decode($order->order_details_json, true);
                                    if ($jsonData !== null) {
                                        echo esc(json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                                    } else {
                                        echo esc($order->order_details_json);
                                    }
                                ?></pre>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Customer Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> <?= esc($order->first_name . ' ' . $order->last_name); ?></p>
                                <p><strong>Email:</strong> <?= esc($order->email); ?></p>
                                <?php if (isset($order->phone)): ?>
                                    <p><strong>Phone:</strong> <?= esc($order->phone); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <?php if (isset($order->nationality)): ?>
                                    <p><strong>Nationality:</strong> <?= esc($order->nationality); ?></p>
                                <?php endif; ?>
                                <?php if (isset($order->social)): ?>
                                    <p><strong>Social:</strong> <?= esc($order->social); ?></p>
                                <?php endif; ?>
                                <?php if (isset($order->social_num)): ?>
                                    <p><strong>Social Number:</strong> <?= esc($order->social_num); ?></p>
                                <?php endif; ?>
                                <p><strong>User ID:</strong> <?= esc($order->user_id); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Location Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Pickup Location:</strong></p>
                                <p class="ms-3"><?= esc($order->pickup_location ?? 'N/A'); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Dropoff Location:</strong></p>
                                <p class="ms-3"><?= esc($order->dropoff_location ?? 'N/A'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Luggage Items -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Luggage Items</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($luggage_items)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Weight (kg)</th>
                                            <th>Dimensions</th>
                                            <th>Special Instructions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($luggage_items as $index => $item): ?>
                                            <tr>
                                                <td><?= $index + 1; ?></td>
                                                <td><?= esc($item->luggage_type ?? 'Standard'); ?></td>
                                                <td><?= esc($item->weight ?? 'N/A'); ?></td>
                                                <td>
                                                    <?php if (isset($item->length, $item->width, $item->height)): ?>
                                                        <?= esc($item->length); ?> × <?= esc($item->width); ?> × <?= esc($item->height); ?> cm
                                                    <?php else: ?>
                                                        N/A
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= esc($item->special_instructions ?? '-'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No luggage items found for this order.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Delivery Information -->
                <?php if (isset($delivery) && $delivery): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Delivery Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Driver:</strong> <?= esc($delivery->driver_name ?? 'Not assigned'); ?></p>
                                    <p><strong>Delivery Status:</strong>
                                        <span class="badge badge-info"><?= esc($delivery->delivery_status ?? 'Pending'); ?></span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <?php if (isset($delivery->estimated_delivery_time)): ?>
                                        <p><strong>Estimated Delivery:</strong> <?= date('M d, Y h:i A', strtotime($delivery->estimated_delivery_time)); ?></p>
                                    <?php endif; ?>
                                    <?php if (isset($delivery->actual_delivery_time)): ?>
                                        <p><strong>Actual Delivery:</strong> <?= date('M d, Y h:i A', strtotime($delivery->actual_delivery_time)); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Storage Tracking -->
                <?php if (isset($storage_tracking) && $storage_tracking): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Storage Tracking</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Storage Location:</strong> <?= esc($storage_tracking->location_name ?? 'N/A'); ?></p>
                                    <?php if (isset($storage_tracking->check_in_time)): ?>
                                        <p><strong>Check-in Time:</strong> <?= date('M d, Y h:i A', strtotime($storage_tracking->check_in_time)); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <?php if (isset($storage_tracking->check_out_time)): ?>
                                        <p><strong>Check-out Time:</strong> <?= date('M d, Y h:i A', strtotime($storage_tracking->check_out_time)); ?></p>
                                    <?php endif; ?>
                                    <?php if (isset($storage_tracking->storage_duration)): ?>
                                        <p><strong>Storage Duration:</strong> <?= esc($storage_tracking->storage_duration); ?> days</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Admin Notes Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0"><i class="fa fa-sticky-note me-2"></i>Admin Notes</h4>
                            <button class="btn btn-sm btn-primary" id="toggleNoteEdit">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Display Mode -->
                        <div id="noteDisplayMode">
                            <?php if (isset($order->special_note) && $order->special_note): ?>
                                <div class="alert alert-info mb-0">
                                    <?= nl2br(esc($order->special_note)); ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0">
                                    <i class="fa fa-info-circle me-2"></i>No notes added yet. Click "Edit" to add notes for this order.
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Edit Mode -->
                        <div id="noteEditMode" style="display: none;">
                            <form id="inlineNoteForm">
                                <div class="form-group">
                                    <label for="inlineOrderNote">Special Note</label>
                                    <textarea class="form-control" id="inlineOrderNote" name="note" rows="5" placeholder="Write your note here..."><?= esc($order->special_note ?? ''); ?></textarea>
                                    <small class="form-text text-muted">These notes are only visible to admin staff.</small>
                                </div>
                                <div class="mt-3">
                                    <button type="button" id="saveInlineNote" class="btn btn-success">
                                        <i class="fa fa-save"></i> Save Note
                                    </button>
                                    <button type="button" id="cancelNoteEdit" class="btn btn-secondary">
                                        <i class="fa fa-times"></i> Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Payment Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Payment Information</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($order->payment_amount)): ?>
                            <p><strong>Amount:</strong> <span class="text-success fw-bold">RM <?= number_format($order->payment_amount, 2); ?></span></p>
                            <p><strong>Method:</strong> <?= esc($order->payment_method ?? 'N/A'); ?></p>
                            <p><strong>Status:</strong>
                                <?php
                                $paymentColor = match($order->payment_status ?? '') {
                                    'Completed' => 'success',
                                    'Pending' => 'warning',
                                    'Failed' => 'danger',
                                    default => 'secondary'
                                };
                                ?>
                                <span class="badge badge-<?= $paymentColor; ?>"><?= esc($order->payment_status ?? 'Unknown'); ?></span>
                            </p>
                        <?php else: ?>
                            <p class="text-muted">No payment information available.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Update Order Status -->
                <?php if (!$order->is_cancelled): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Update Order Status</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('orders/updateStatus/' . $order->order_id); ?>">
                                <?= csrf_field(); ?>
                                <div class="form-group">
                                    <label for="order_status">Order Status</label>
                                    <select name="order_status" id="order_status" class="form-control" required>
                                        <option value="Pending" <?= $order->order_status === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Confirmed" <?= $order->order_status === 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                        <option value="In_Storage" <?= $order->order_status === 'In_Storage' ? 'selected' : ''; ?>>In Storage</option>
                                        <option value="Out-for-Delivery" <?= $order->order_status === 'Out-for-Delivery' ? 'selected' : ''; ?>>Out for Delivery</option>
                                        <option value="Completed" <?= $order->order_status === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>

                                <div class="form-group" id="cancellation_reason_group" style="display: none;">
                                    <label for="cancellation_reason">Cancellation Reason</label>
                                    <textarea name="cancellation_reason" id="cancellation_reason" class="form-control" rows="3"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block mt-3">
                                    <i class="fa fa-save"></i> Update Status
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Actions -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Actions</h4>
                    </div>
                    <div class="card-body">
                        <a href="<?= base_url('orders'); ?>" class="btn btn-secondary btn-block mb-2">
                            <i class="fa fa-arrow-left"></i> Back to Orders
                        </a>
                        <button class="btn btn-warning btn-block mb-2 btn-add-note"
                            data-id="<?= $order->order_id; ?>"
                            data-note="<?= htmlspecialchars($order->special_note ?? '', ENT_QUOTES); ?>">
                            <i class="fa fa-sticky-note"></i> Add/Edit Note
                        </button>
                        <button onclick="window.print()" class="btn btn-info btn-block">
                            <i class="fa fa-print"></i> Print Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Show/hide cancellation reason field
    document.getElementById('order_status').addEventListener('change', function() {
        const cancellationGroup = document.getElementById('cancellation_reason_group');
        const cancellationField = document.getElementById('cancellation_reason');

        if (this.value === 'Cancelled') {
            cancellationGroup.style.display = 'block';
            cancellationField.required = true;
        } else {
            cancellationGroup.style.display = 'none';
            cancellationField.required = false;
        }
    });

    // Inline Note Edit Toggle
    const toggleNoteEditBtn = document.getElementById('toggleNoteEdit');
    const noteDisplayMode = document.getElementById('noteDisplayMode');
    const noteEditMode = document.getElementById('noteEditMode');
    const cancelNoteEditBtn = document.getElementById('cancelNoteEdit');

    if (toggleNoteEditBtn) {
        toggleNoteEditBtn.addEventListener('click', function() {
            noteDisplayMode.style.display = 'none';
            noteEditMode.style.display = 'block';
            this.style.display = 'none';
        });
    }

    if (cancelNoteEditBtn) {
        cancelNoteEditBtn.addEventListener('click', function() {
            noteDisplayMode.style.display = 'block';
            noteEditMode.style.display = 'none';
            toggleNoteEditBtn.style.display = 'block';
        });
    }

    // Save Inline Note
    const saveInlineNoteBtn = document.getElementById('saveInlineNote');
    if (saveInlineNoteBtn) {
        saveInlineNoteBtn.addEventListener('click', function() {
            const orderId = <?= $order->order_id; ?>;
            const note = document.getElementById('inlineOrderNote').value;

            // Get CSRF token
            const csrfName = '<?= csrf_token(); ?>';
            const csrfHash = '<?= csrf_hash(); ?>';

            fetch('<?= base_url("/save_note"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: csrfName + '=' + encodeURIComponent(csrfHash) + '&order_id=' + encodeURIComponent(orderId) + '&note=' + encodeURIComponent(note)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Note Saved!',
                            text: 'The admin note has been successfully saved.',
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
    }

    // Add/Edit Note functionality (Modal version)
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
</script>

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

<?= $this->include('admin/footer'); ?>
