<?= $this->include('admin/header'); ?>

<div class="container mt-4">
    <h3>Service Base Prices</h3>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <table class="table">
        <thead>
            <tr>
                <th>Service Type</th>
                <th>Base Price (RM)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($services as $service): ?>
            <tr>
                <td><?= esc(ucfirst($service['service_type'])) ?></td>
                <td>
                    <form method="post" action="<?= base_url('/admin/service_management/update/'.$service['id']) ?>" style="display:inline;">
                        <?= csrf_field() ?>
                        <input type="number" step="1" name="base_price" value="<?= esc($service['base_price']) ?>" style="width:80px;">
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->include('admin/footer'); ?>