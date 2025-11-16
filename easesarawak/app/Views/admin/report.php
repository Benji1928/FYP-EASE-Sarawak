<!-- Old Report Page -->
<?= $this->include('admin/header'); ?>

<?php
    $reportStartDate = $reportStartDate ?? date('Y-m-01');
    $reportEndDate = $reportEndDate ?? date('Y-m-d');
    $analyticsExportConfig = [
        'revenue' => [
            'action' => base_url('admin/analytics/export/revenue'),
            'sections' => [
                'daily' => 'Daily Totals',
                'channel' => 'By Channel',
                'service' => 'By Service',
            ],
        ],
        'customers' => [
            'action' => base_url('admin/analytics/export/customers'),
            'sections' => [
                'lifetime' => 'Top Customers',
                'segments' => 'Customer Segments',
                'acquisition' => 'Acquisition Trend',
            ],
        ],
        'operations' => [
            'action' => base_url('admin/analytics/export/operations'),
            'sections' => [
                'daily' => 'Daily Summary',
                'delivery' => 'Delivery Performance',
                'storage' => 'Storage Occupancy',
            ],
        ],
    ];
?>

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
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Export Analytics</h5>
                    <p class="text-muted small">Download any analytics dataset in CSV, PDF, or JSON.</p>
                    <form id="analyticsExportForm" method="get" action="<?= base_url('admin/analytics/export/revenue'); ?>">
                        <div class="mb-2">
                            <label class="form-label">Dataset Type</label>
                            <select id="analyticsExportType" name="type" class="form-select form-select-sm">
                                <option value="revenue">Revenue</option>
                                <option value="customers">Customers</option>
                                <option value="operations">Operations</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Data Slice</label>
                            <select id="analyticsExportSection" name="section" class="form-select form-select-sm">
                                <option value="daily">Daily Totals</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Format</label>
                            <select name="format" class="form-select form-select-sm">
                                <option value="csv">CSV</option>
                                <option value="pdf">PDF</option>
                                <option value="json">JSON</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control form-control-sm" value="<?= esc($reportStartDate); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control form-control-sm" value="<?= esc($reportEndDate); ?>">
                        </div>
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="fa fa-download"></i> Export
                        </button>
                    </form>
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
    const analyticsExportConfig = <?= json_encode($analyticsExportConfig, JSON_UNESCAPED_SLASHES); ?>;
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

    const analyticsExportForm = document.getElementById('analyticsExportForm');
    const analyticsExportType = document.getElementById('analyticsExportType');
    const analyticsExportSection = document.getElementById('analyticsExportSection');

    function populateAnalyticsSections(type) {
        if (!analyticsExportConfig[type] || !analyticsExportSection) {
            return;
        }

        analyticsExportSection.innerHTML = '';
        Object.entries(analyticsExportConfig[type].sections).forEach(([value, label], index) => {
            const option = document.createElement('option');
            option.value = value;
            option.textContent = label;
            if (index === 0) {
                option.selected = true;
            }
            analyticsExportSection.appendChild(option);
        });
    }

    function updateAnalyticsExportTarget(type) {
        if (!analyticsExportConfig[type] || !analyticsExportForm) {
            return;
        }
        analyticsExportForm.action = analyticsExportConfig[type].action;
        populateAnalyticsSections(type);
    }

    if (analyticsExportForm && analyticsExportType) {
        updateAnalyticsExportTarget(analyticsExportType.value);
        analyticsExportType.addEventListener('change', function () {
            updateAnalyticsExportTarget(this.value);
        });
    }

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
