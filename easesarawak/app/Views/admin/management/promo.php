<?php
// File: /e:/xampp/htdocs/FYP/easesarawak/app/Views/admin/promo.php
// Expect $promos array of promo objects/arrays from controller
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Promo Codes — Admin</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .table-actions button { margin-right: .25rem; }
        .cursor-pointer { cursor: pointer; }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Promo Codes</h3>
        <div>
            <button id="btnNew" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#promoModal">New Promo</button>
            <a class="btn btn-outline-secondary" href="<?= isset($backUrl) ? esc($backUrl) : base_url('/dashboard') ?>">Back</a>
        </div>
    </div>

    <div id="alertPlaceholder"></div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle" id="promoTable">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Discount</th>
                    <th>Validity</th>
                    <th>Usage</th>
                    <th>Active</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($promos) && is_array($promos)): ?>
                    <?php foreach ($promos as $p): 
                        // normalize
                        $id = isset($p['id']) ? $p['id'] : (isset($p->id) ? $p->id : null);
                        $code = isset($p['code']) ? $p['code'] : (isset($p->code) ? $p->code : '');
                        $desc = isset($p['description']) ? $p['description'] : (isset($p->description) ? $p->description : '');
                        $type = isset($p['discount_type']) ? $p['discount_type'] : (isset($p->discount_type) ? $p->discount_type : 'fixed');
                        $value = isset($p['discount_value']) ? $p['discount_value'] : (isset($p->discount_value) ? $p->discount_value : 0);
                        $start = isset($p['start_date']) ? $p['start_date'] : (isset($p->start_date) ? $p->start_date : '');
                        $end = isset($p['end_date']) ? $p['end_date'] : (isset($p->end_date) ? $p->end_date : '');
                        $limit = isset($p['usage_limit']) ? $p['usage_limit'] : (isset($p->usage_limit) ? $p->usage_limit : null);
                        $used = isset($p['used_count']) ? $p['used_count'] : (isset($p->used_count) ? $p->used_count : 0);
                        $active = isset($p['active']) ? (bool)$p['active'] : (isset($p->active) ? (bool)$p->active : false);
                    ?>
                    <tr data-id="<?= esc($id) ?>">
                        <td><strong><?= esc($code) ?></strong></td>
                        <td><?= esc($desc) ?></td>
                        <td>
                            <?php if ($type === 'percent'): ?>
                                <?= esc($value) ?>%
                            <?php else: ?>
                                RM <?= number_format((float)$value, 2) ?>
                            <?php endif; ?>
                            <div class="text-muted small"><?= esc($type) ?></div>
                        </td>
                        <td>
                            <?php if ($start || $end): ?>
                                <?= esc($start ?: '—') ?> → <?= esc($end ?: '—') ?>
                            <?php else: ?>
                                Always
                            <?php endif; ?>
                        </td>
                        <td><?= esc($used) ?><?= is_null($limit) ? '' : ' / ' . esc($limit) ?></td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input toggle-active cursor-pointer" type="checkbox" <?= $active ? 'checked' : '' ?> data-id="<?= esc($id) ?>">
                            </div>
                        </td>
                        <td class="text-end table-actions">
                            <button class="btn btn-sm btn-outline-primary btnEdit" data-id="<?= esc($id) ?>">Edit</button>
                            <button class="btn btn-sm btn-outline-danger btnDelete" data-id="<?= esc($id) ?>">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-muted">No promo codes found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Create / Edit -->
<div class="modal fade" id="promoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="promoForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="promoModalTitle">New Promo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="promoId" value="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Code</label>
                        <input name="code" id="promoCode" class="form-control" required maxlength="50" placeholder="E.g. SPRING2025">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <input name="description" id="promoDesc" class="form-control" maxlength="255" placeholder="Short description">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Discount Type</label>
                        <select name="discount_type" id="promoType" class="form-select">
                            <option value="fixed">Fixed (RM)</option>
                            <option value="percent">Percent (%)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Value</label>
                        <input name="discount_value" id="promoValue" type="number" step="0.01" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Usage limit (optional)</label>
                        <input name="usage_limit" id="promoLimit" type="number" min="0" class="form-control" placeholder="Leave blank for unlimited">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Start date (optional)</label>
                        <input name="start_date" id="promoStart" type="datetime-local" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">End date (optional)</label>
                        <input name="end_date" id="promoEnd" type="datetime-local" class="form-control">
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input name="active" class="form-check-input" id="promoActive" type="checkbox" checked>
                            <label class="form-check-label" for="promoActive">Active</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="promoSave" type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    const base = '<?= base_url('/promo') ?>';

    function showAlert(msg, type = 'success', timeout = 4000) {
        const id = 'a' + Date.now();
        $('#alertPlaceholder').append(
            `<div id="${id}" class="alert alert-${type} alert-dismissible fade show" role="alert">
                 ${msg}
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>`);
        if (timeout) setTimeout(() => $('#' + id).alert('close'), timeout);
    }

    // Reset modal form for new
    $('#btnNew').on('click', () => {
        $('#promoModalTitle').text('New Promo');
        $('#promoForm')[0].reset();
        $('#promoId').val('');
        $('#promoValue').attr('step', '0.01');
    });

    // Edit button: fetch details and populate
    $(document).on('click', '.btnEdit', function () {
        const id = $(this).data('id');
        if (!id) return;
        $.getJSON(base + '/get/' + id).done(function (data) {
            // expects JSON object with fields
            $('#promoModalTitle').text('Edit Promo');
            $('#promoId').val(data.id || '');
            $('#promoCode').val(data.code || '');
            $('#promoDesc').val(data.description || '');
            $('#promoType').val(data.discount_type || 'fixed');
            $('#promoValue').val(data.discount_value || 0);
            if (data.usage_limit !== null && data.usage_limit !== undefined) $('#promoLimit').val(data.usage_limit);
            else $('#promoLimit').val('');
            // convert YYYY-MM-DD hh:mm:ss to datetime-local if possible
            function toLocal(v){
                if (!v) return '';
                // try to create Date
                const d = new Date(v.replace(' ', 'T'));
                if (isNaN(d)) return '';
                // format to yyyy-mm-ddThh:mm
                const pad = n => String(n).padStart(2,'0');
                return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
            }
            $('#promoStart').val(toLocal(data.start_date));
            $('#promoEnd').val(toLocal(data.end_date));
            $('#promoActive').prop('checked', !!data.active);
            $('#promoModal').modal('show');
        }).fail(function (xhr) {
            showAlert('Failed to load promo data.', 'danger');
        });
    });

    // Save (create/update)
    $('#promoForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#promoId').val();
        const url = id ? base + '/update/' + id : base + '/create';
        const method = id ? 'PUT' : 'POST';

        // gather form data
        const payload = {
            code: $('#promoCode').val().trim(),
            description: $('#promoDesc').val().trim(),
            discount_type: $('#promoType').val(),
            discount_value: $('#promoValue').val(),
            usage_limit: $('#promoLimit').val() === '' ? null : $('#promoLimit').val(),
            start_date: $('#promoStart').val() || null,
            end_date: $('#promoEnd').val() || null,
            active: $('#promoActive').is(':checked') ? 1 : 0
        };

        $('#promoSave').prop('disabled', true);
        $.ajax({
            url: url,
            method: method,
            contentType: 'application/json; charset=utf-8',
            data: JSON.stringify(payload),
            dataType: 'json'
        }).done(function (res) {
            if (res && res.success) {
                showAlert(res.message || 'Saved successfully.');
                // simple page refresh to reflect changes; you can replace with smarter DOM updates
                setTimeout(() => location.reload(), 700);
            } else {
                showAlert((res && res.message) || 'Save failed', 'danger');
            }
        }).fail(function (xhr) {
            showAlert('Request failed: ' + (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText), 'danger');
        }).always(function () {
            $('#promoSave').prop('disabled', false);
            $('#promoModal').modal('hide');
        });
    });

    // Delete
    $(document).on('click', '.btnDelete', function () {
        const id = $(this).data('id');
        if (!id) return;
        if (!confirm('Delete this promo? This action cannot be undone.')) return;
        $.ajax({
            url: base + '/delete/' + id,
            method: 'DELETE'
        }).done(function (res) {
            if (res && res.success) {
                showAlert(res.message || 'Deleted.');
                setTimeout(() => location.reload(), 500);
            } else showAlert((res && res.message) || 'Delete failed', 'danger');
        }).fail(function () {
            showAlert('Delete request failed.', 'danger');
        });
    });

    // Toggle active
    $(document).on('change', '.toggle-active', function () {
        const id = $(this).data('id');
        const active = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            url: base + '/toggle/' + id,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ active: active })
        }).done(function (res) {
            if (res && res.success) showAlert(res.message || 'Updated.');
            else {
                showAlert((res && res.message) || 'Update failed', 'danger');
                // revert switch
                $(this).prop('checked', !active);
            }
        }.bind(this)).fail(function () {
            showAlert('Update failed.', 'danger');
            $(this).prop('checked', !active);
        }.bind(this));
    });

    // Helpful keyboard: press N to open New modal
    $(document).on('keydown', function (e) {
        if (e.key.toLowerCase() === 'n' && !$('#promoModal').hasClass('show') && !$('input,textarea').is(':focus')) {
            $('#btnNew').trigger('click');
        }
    });

})();
</script>
</body>
</html>