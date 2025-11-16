<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3"><?= esc($title ?? 'External Data Dashboard'); ?></h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="<?= base_url('dashboard'); ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Analytics</a>
                </li>
                <li class="separator">
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="nav-item">External Data</li>
            </ul>
        </div>

        <!-- Tourist Arrivals -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fas fa-plane-arrival"></i> Tourist Arrivals Data
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Period Start</th>
                                        <th>Period End</th>
                                        <th class="text-end">International</th>
                                        <th class="text-end">Domestic</th>
                                        <th class="text-end">Total</th>
                                        <th>Source</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($tourist_arrivals)): ?>
                                        <?php foreach ($tourist_arrivals as $data): ?>
                                            <tr>
                                                <td><?= date('M d, Y', strtotime($data->period_start)); ?></td>
                                                <td><?= date('M d, Y', strtotime($data->period_end)); ?></td>
                                                <td class="text-end"><?= number_format($data->international_arrivals ?? 0); ?></td>
                                                <td class="text-end"><?= number_format($data->domestic_arrivals ?? 0); ?></td>
                                                <td class="text-end"><strong><?= number_format($data->total_arrivals ?? 0); ?></strong></td>
                                                <td><small class="text-muted"><?= esc($data->data_source ?? 'N/A'); ?></small></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                <i class="fas fa-info-circle"></i> No tourist arrival data available
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fas fa-calendar-alt"></i> Upcoming Local Events
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Category</th>
                                        <th>Location</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th class="text-end">Expected Attendees</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($upcoming_events)): ?>
                                        <?php foreach ($upcoming_events as $event): ?>
                                            <tr>
                                                <td><strong><?= esc($event->event_name); ?></strong></td>
                                                <td>
                                                    <span class="badge badge-info"><?= esc($event->event_category ?? 'N/A'); ?></span>
                                                </td>
                                                <td><?= esc($event->event_location ?? 'N/A'); ?></td>
                                                <td><?= date('M d, Y', strtotime($event->event_start_date)); ?></td>
                                                <td><?= date('M d, Y', strtotime($event->event_end_date)); ?></td>
                                                <td class="text-end">
                                                    <?php if ($event->expected_attendees): ?>
                                                        <span class="badge badge-primary"><?= number_format($event->expected_attendees); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                <i class="fas fa-info-circle"></i> No upcoming events found
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hotel Occupancy Stats -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fas fa-hotel"></i> Hotel Occupancy Trends
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Period</th>
                                        <th>Region</th>
                                        <th class="text-end">Occupancy Rate</th>
                                        <th class="text-end">Average Daily Rate (RM)</th>
                                        <th class="text-end">Total Rooms</th>
                                        <th>Source</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($hotel_occupancy)): ?>
                                        <?php foreach ($hotel_occupancy as $stat): ?>
                                            <tr>
                                                <td><?= date('M Y', strtotime($stat->period_date)); ?></td>
                                                <td><?= esc($stat->region ?? 'Sarawak'); ?></td>
                                                <td class="text-end">
                                                    <div class="progress" style="width: 100px; height: 20px;">
                                                        <div class="progress-bar <?php
                                                            $rate = $stat->occupancy_rate ?? 0;
                                                            if ($rate >= 80) echo 'bg-success';
                                                            elseif ($rate >= 60) echo 'bg-info';
                                                            elseif ($rate >= 40) echo 'bg-warning';
                                                            else echo 'bg-danger';
                                                        ?>" role="progressbar" style="width: <?= $rate; ?>%">
                                                            <?= number_format($rate, 1); ?>%
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">RM <?= number_format($stat->average_daily_rate ?? 0, 2); ?></td>
                                                <td class="text-end"><?= number_format($stat->total_rooms ?? 0); ?></td>
                                                <td><small class="text-muted"><?= esc($stat->data_source ?? 'N/A'); ?></small></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                <i class="fas fa-info-circle"></i> No hotel occupancy data available
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>About External Data:</strong>
                    This dashboard integrates external data sources to help predict demand and optimize operations.
                    Data is synchronized from Sarawak Tourism Board, event calendars, and hotel associations.
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/footer'); ?>
