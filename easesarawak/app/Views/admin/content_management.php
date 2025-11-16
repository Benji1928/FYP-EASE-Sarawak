<?= $this->include('admin/header'); ?>

<style>
    .content-form-container {
        max-width: 600px;
        margin: 2rem auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        padding: 1rem 2.5rem 1.5rem 2.5rem;
    }
    .content-form-container h3 {
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #2a3b4c;
        text-align: center;
    }
    .content-form-container .form-label {
        font-weight: 600;
        color: #2a3b4c;
    }
    .content-form-container .form-control {
        border-radius: 6px;
        border: 1px solid #d1d5db;
        margin-bottom: 1rem;
        font-size: 1rem;
        padding: 0.6rem 0.9rem;
    }
    .content-form-container textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }
    .content-form-container .btn-primary {
        background: #1e88e5;
        border: none;
        padding: 0.6rem 2.2rem;
        font-size: 1.1rem;
        border-radius: 6px;
        font-weight: 600;
        transition: background 0.2s;
    }
    .content-form-container .btn-primary:hover {
        background: #1565c0;
    }
    .content-form-container .alert {
        margin-bottom: 1.2rem;
    }
    .content-table-container {
        max-width: 1100px;
        margin: 2rem auto 1rem auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        padding: 2rem;
        padding-top: 4rem;
    }
    table.content-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.5rem;
    }
    table.content-table th, table.content-table td {
        border: 1px solid #e0e0e0;
        padding: 0.7rem 0.5rem;
        text-align: left;
    }
    table.content-table th {
        background: #f2f2f2;
        font-weight: 600;
    }
    .active-badge {
        background: #1e88e5;
        color: #fff;
        padding: 0.2rem 0.7rem;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 600;
    }
    .inactive-badge {
        background: #ccc;
        color: #333;
        padding: 0.2rem 0.7rem;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 600;
    }
    .btn-set-active {
        background: #f2be00;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 0.3rem 1rem;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-set-active:hover {
        background: #1565c0;
    }
    .content-table td:last-child {
        text-align: right;
    }
</style>

<div class="content-table-container">
    <h3>All Content</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Title</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Set Active</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contentData as $row): ?>
                <tr>
                    <td><?= esc($row['id']) ?></td>
                    <td><?= esc(ucfirst($row['type'])) ?></td>
                    <td><?= esc($row['title']) ?></td>
                    <td><?= esc($row['created_at']) ?></td>
                    <td>
                        <?php if (!empty($row['is_active'])): ?>
                            <span class="active-badge">Active</span>
                        <?php else: ?>
                            <span class="inactive-badge">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (empty($row['is_active'])): ?>
                            <form method="post" action="<?= base_url('/admin/content_management/set_active/'.$row['id']) ?>" style="display:inline;">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-set-active">Set Active</button>
                            </form>
                        <?php else: ?>
                            <span class="active-badge">Current</span>
                            <form method="post" action="<?= base_url('/admin/content_management/set_inactive/'.$row['id']) ?>" style="display:inline; margin-left:8px;">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-set-active" style="background:#888;">Set Inactive</button>
                            </form>
                        <?php endif; ?>
                    <td>
                        <form method="post" action="<?= base_url('/admin/content_management/delete/'.$row['id']) ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this content?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn-set-active" style="background:#e53935;">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="content-form-container">
    <h3>Add New Content</h3>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" action="<?= base_url('/admin/content_management/store') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="type" class="form-label">Content Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="">Select Page</option>
                <option value="main">Main Page</option>
                <option value="booking">Booking Page</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" id="content" class="form-control" rows="6" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Background Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Add Content</button>
    </form>
</div>

<?= $this->include('admin/footer'); ?>