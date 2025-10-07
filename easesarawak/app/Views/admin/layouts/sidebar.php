<!-- Sidebar -->
<div class="bg-dark border-end" id="sidebar-wrapper">
    <div class="sidebar-heading text-white p-3 fs-5 fw-bold">Admin Panel</div>
    <div class="list-group list-group-flush">
        <a href="<?= base_url('admin/dashboard') ?>" class="list-group-item list-group-item-action bg-dark text-white">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a href="<?= base_url('admin/users') ?>" class="list-group-item list-group-item-action bg-dark text-white">
            <i class="fas fa-users me-2"></i> Users
        </a>
        <a href="<?= base_url('admin/reports') ?>" class="list-group-item list-group-item-action bg-dark text-white">
            <i class="fas fa-chart-bar me-2"></i> Reports
        </a>
        <a href="<?= base_url('admin/settings') ?>" class="list-group-item list-group-item-action bg-dark text-white">
            <i class="fas fa-cog me-2"></i> Settings
        </a>
    </div>
</div>
<!-- /#sidebar-wrapper -->