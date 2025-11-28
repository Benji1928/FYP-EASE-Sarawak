<?php if (!empty($logs)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Action</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= esc($log['username']); ?></td>
                    <td><?= esc($log['action']); ?></td>
                    <td><?= date('d M Y, h:i A', strtotime($log['modified_date'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="text-center py-4 text-muted">No activity found.</div>
<?php endif; ?>