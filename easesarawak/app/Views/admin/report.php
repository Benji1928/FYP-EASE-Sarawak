<?= $this->include('admin/header'); ?>

<div class="container-fluid mt-4">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Analytics & Reports</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="<?= base_url('/admin/dashboard'); ?>">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="fa fa-angle-right"></i>
            </li>
            <li class="nav-item">Reports</li>
        </ul>
    </div>

    <!-- Overview Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <h2 class="fw-bold text-success">RM <?= number_format($totalRevenue, 2); ?></h2>
                    <p class="text-muted mb-0">All Time</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <h2 class="fw-bold text-primary"><?= $totalOrders; ?></h2>
                    <p class="text-muted mb-0">All Time</p>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">Active Users</h5>
                    <h2 class="fw-bold text-warning"></h2>
                    <p class="text-muted mb-0">Currently Active</p>
                </div>
            </div>
        </div> -->
    </div>

    <!-- Revenue Breakdown -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Revenue Breakdown (Last 6 Months)</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Peak Booking Times -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Peak Booking Times</h5>
                </div>
                <div class="card-body">
                    <canvas id="peakTimesChart" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Breakdown (Line Chart)
    const months = <?= json_encode($months ?? []); ?>;
    const revenues = <?= json_encode($revenues ?? []); ?>;

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue (RM)',
                data: revenues,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78,115,223,0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Peak Booking Times (Bar Chart)
    const hours = <?= json_encode($hours ?? []); ?>;
    const counts = <?= json_encode($hourCounts ?? []); ?>;

    new Chart(document.getElementById('peakTimesChart'), {
        type: 'bar',
        data: {
            labels: hours.map(h => h + ':00'),
            datasets: [{
                label: 'Orders',
                data: counts,
                backgroundColor: '#1cc88a'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

<?= $this->include('admin/footer'); ?>