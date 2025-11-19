<?= $this->include('admin/header'); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container mt-4">
    <div class="page-inner" style="padding-top: 80px;">
        <div class="d-flex align-items-center mb-4">
            <h3 class="fw-bold mb-0 me-3"><i class="fas fa-ticket-alt me-2"></i>Create Promo Code</h3>
        </div>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('/admin/promo_code/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" class="form-control" value="<?= esc(old('code')) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Discount (%)</label>
                        <input type="number" name="discount_percentage" class="form-control" min="0" max="100" value="<?= esc(old('discount_percentage')) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Valid From</label>
                        <input type="text" id="validation_date" name="validation_date" class="form-control datetimepicker" value="<?= esc(old('validation_date')) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Expires</label>
                        <input type="text" id="expired_date" name="expired_date" class="form-control datetimepicker" value="<?= esc(old('expired_date')) ?>" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('/admin/promo_code') ?>" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Promo</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    flatpickr(".datetimepicker", { enableTime: true, dateFormat: "Y-m-d H:i", time_24hr: true, allowInput: true });
});
</script>

<?= $this->include('admin/footer'); ?>