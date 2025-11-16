<!-- Old Report Page -->
<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Analytics & Reports</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="<?= base_url('admin'); ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/analytics'); ?>">Analytics</a>
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
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <button id="exportCsv" class="btn btn-sm ms-2">
                    <i class="fa fa-download"></i> Export CSV
                </button>
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Revenue Breakdown</h5>

                    <!-- Filter Controls -->
                    <div class="d-flex align-items-center">
                        <select id="serviceType" class="form-select form-select-sm me-2">
                            <option value="all">All Services</option>
                            <option value="storage">Storage</option>
                            <option value="delivery">Delivery</option>
                        </select>

                        <select id="timeframe" class="form-select form-select-sm">
                            <option value="day">Day</option>
                            <option value="week">Week</option>
                            <option value="month" selected>Month</option>
                        </select>
                    </div>
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
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let revenueChart;

    // Initial render
    function loadRevenueData(serviceType = 'all', timeframe = 'month') {
        fetch(`<?= base_url('admin/getRevenueData'); ?>?service=${serviceType}&timeframe=${timeframe}`)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('revenueChart').getContext('2d');
                if (revenueChart) revenueChart.destroy();

                revenueChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Revenue (RM)',
                            data: data.values,
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
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    }

    // Event listeners for filters
    document.getElementById('serviceType').addEventListener('change', function() {
        loadRevenueData(this.value, document.getElementById('timeframe').value);
    });

    document.getElementById('timeframe').addEventListener('change', function() {
        loadRevenueData(document.getElementById('serviceType').value, this.value);
    });

    document.getElementById('exportCsv').addEventListener('click', function () {
        const service = document.getElementById('serviceType').value;
        const timeframe = document.getElementById('timeframe').value;
        const url = new URL('<?= base_url('admin/export-revenue'); ?>', window.location.origin);
        url.searchParams.set('service', service);
        url.searchParams.set('timeframe', timeframe);
        window.location.href = url.toString();
    });

    // Load default chart
    loadRevenueData();

    // Peak Booking Times (static or preloaded)
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