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
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Revenue</h5>
                    <h2 class="fw-bold text-success">RM 25,450</h2>
                    <p class="text-muted mb-0">This Month</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Bookings</h5>
                    <h2 class="fw-bold text-primary">324</h2>
                    <p class="text-muted mb-0">All Time</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Active Customers</h5>
                    <h2 class="fw-bold text-warning">189</h2>
                    <p class="text-muted mb-0">Last 30 Days</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Breakdown -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Revenue Breakdown</h5>
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

    <!-- Customer Demographics -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Customer Demographics</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <canvas id="demographicsChart" height="120"></canvas>
                        </div>
                        <div class="col-md-4">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fa fa-male me-2"></i> Male</span>
                                    <span class="badge bg-primary rounded-pill">55%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fa fa-female me-2"></i> Female</span>
                                    <span class="badge bg-danger rounded-pill">45%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fa fa-user me-2"></i> Age 18–30</span>
                                    <span class="badge bg-info rounded-pill">48%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fa fa-user me-2"></i> Age 31–50</span>
                                    <span class="badge bg-secondary rounded-pill">37%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fa fa-user me-2"></i> Age 50+</span>
                                    <span class="badge bg-dark rounded-pill">15%</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Revenue Breakdown (Line Chart)
    const ctx1 = document.getElementById('revenueChart');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            datasets: [{
                label: 'Revenue (RM)',
                data: [1800, 2200, 3000, 2600, 3100, 4000, 4500, 3800, 5100],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78,115,223,0.1)',
                tension: 0.3,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Peak Booking Times (Bar Chart)
    const ctx2 = document.getElementById('peakTimesChart');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['8AM', '10AM', '12PM', '2PM', '4PM', '6PM', '8PM'],
            datasets: [{
                label: 'Bookings',
                data: [10, 20, 15, 25, 30, 22, 18],
                backgroundColor: '#1cc88a'
            }]
        },
        options: {
            responsive: true,
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

    // Customer Demographics (Doughnut Chart)
    const ctx3 = document.getElementById('demographicsChart');
    new Chart(ctx3, {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [55, 45],
                backgroundColor: ['#4e73df', '#e74a3b']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

<?= $this->include('admin/footer'); ?>