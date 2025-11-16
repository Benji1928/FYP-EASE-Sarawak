<?= $this->include('admin/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3"><?= esc($title ?? 'Revenue Analytics'); ?></h3>
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
                <li class="nav-item">Revenue Breakdown</li>
            </ul>
        </div>

        <!-- Date Range Filter -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="get" action="<?= base_url('admin/analytics/revenue'); ?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="<?= esc($start_date); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" name="end_date" class="form-control" value="<?= esc($end_date); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary form-control">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue by Channel -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Revenue by Channel</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Channel</th>
                                        <th class="text-end">Transactions</th>
                                        <th class="text-end">Revenue (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($revenue_by_channel)): ?>
                                        <?php foreach ($revenue_by_channel as $channel): ?>
                                            <tr>
                                                <td><?= esc($channel->revenue_channel); ?></td>
                                                <td class="text-end"><?= number_format($channel->transaction_count); ?></td>
                                                <td class="text-end">RM <?= number_format($channel->total_revenue, 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Revenue by Service Type</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th class="text-end">Transactions</th>
                                        <th class="text-end">Revenue (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($revenue_by_service)): ?>
                                        <?php foreach ($revenue_by_service as $service): ?>
                                            <tr>
                                                <td><?= esc($service->service_type); ?></td>
                                                <td class="text-end"><?= number_format($service->transaction_count); ?></td>
                                                <td class="text-end">RM <?= number_format($service->total_revenue, 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Revenue Trend -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daily Revenue Breakdown</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th class="text-end">Service Revenue</th>
                                        <th class="text-end">Delivery Revenue</th>
                                        <th class="text-end">Insurance Revenue</th>
                                        <th class="text-end">Partner Commission</th>
                                        <th class="text-end">Net Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($daily_revenue)): ?>
                                        <?php
                                        $totalService = 0;
                                        $totalDelivery = 0;
                                        $totalInsurance = 0;
                                        $totalCommission = 0;
                                        $totalNet = 0;
                                        ?>
                                        <?php foreach ($daily_revenue as $day): ?>
                                            <?php
                                            $totalService += $day->service_revenue;
                                            $totalDelivery += $day->delivery_revenue;
                                            $totalInsurance += $day->insurance_revenue;
                                            $totalCommission += $day->partner_commission;
                                            $totalNet += $day->net_revenue;
                                            ?>
                                            <tr>
                                                <td><?= date('M d, Y', strtotime($day->transaction_date)); ?></td>
                                                <td class="text-end">RM <?= number_format($day->service_revenue, 2); ?></td>
                                                <td class="text-end">RM <?= number_format($day->delivery_revenue, 2); ?></td>
                                                <td class="text-end">RM <?= number_format($day->insurance_revenue, 2); ?></td>
                                                <td class="text-end">RM <?= number_format($day->partner_commission, 2); ?></td>
                                                <td class="text-end"><strong>RM <?= number_format($day->net_revenue, 2); ?></strong></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr class="table-active">
                                            <td><strong>Total</strong></td>
                                            <td class="text-end"><strong>RM <?= number_format($totalService, 2); ?></strong></td>
                                            <td class="text-end"><strong>RM <?= number_format($totalDelivery, 2); ?></strong></td>
                                            <td class="text-end"><strong>RM <?= number_format($totalInsurance, 2); ?></strong></td>
                                            <td class="text-end"><strong>RM <?= number_format($totalCommission, 2); ?></strong></td>
                                            <td class="text-end"><strong>RM <?= number_format($totalNet, 2); ?></strong></td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No revenue data available for the selected period</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/footer'); ?>
