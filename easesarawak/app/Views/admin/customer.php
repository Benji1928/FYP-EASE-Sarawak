<?= $this->include('admin/header'); ?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Customer Report & Analytics</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="<?= base_url('/admin'); ?>">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Reports</a>
                            </li>
                            <li class="separator">
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="nav-item">Customer Report</li>
                        </ul>
                    </div>

                    <!-- Customer Overview Stats -->
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Customers</p>
                                    <h4 class="card-title"><?= number_format($stats['total_users']); ?></h4>
                                    <small class="text-muted"><?= $stats['active_users']; ?> active</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">New This Month</p>
                                    <h4 class="card-title"><?= number_format($stats['new_users_month']); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Avg Rating</p>
                                    <h4 class="card-title"><?= $stats['avg_rating']; ?> / 5.0</h4>
                                    <small class="text-muted"><?= $stats['total_reviews']; ?> reviews</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Avg Order Value</p>
                                    <h4 class="card-title">RM <?= number_format($stats['avg_order_value'], 2); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Customers and Customer Types Row -->
        <div class="row">
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Top Customers by Revenue</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th class="text-end">Total Orders</th>
                                        <th class="text-end">Total Spent</th>
                                        <th class="text-end">Lifetime Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($top_customers)):
                                        foreach ($top_customers as $customer):
                                    ?>
                                        <tr>
                                            <td>
                                                <div><strong><?= esc($customer->first_name . ' ' . $customer->last_name); ?></strong></div>
                                                <small class="text-muted">#<?= esc($customer->user_id); ?></small>
                                            </td>
                                            <td><?= esc($customer->email); ?></td>
                                            <td class="text-end">
                                                <span class="badge badge-info"><?= number_format($customer->total_orders ?? 0); ?></span>
                                            </td>
                                            <td class="text-end">
                                                <strong>RM <?= number_format($customer->total_spent ?? 0, 2); ?></strong>
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-success">RM <?= number_format($customer->lifetime_value ?? 0, 2); ?></strong>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No customer data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <h4 class="card-title">Customer Types</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th class="text-end">Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($customer_types)):
                                        foreach ($customer_types as $type):
                                    ?>
                                        <tr>
                                            <td><?= ucwords(str_replace('_', ' ', esc($type->customer_type))); ?></td>
                                            <td class="text-end">
                                                <span class="badge badge-primary"><?= number_format($type->unique_users); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">No customer data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Channels -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <h4 class="card-title">Booking Channels Performance</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Channel</th>
                                        <th class="text-end">Total Orders</th>
                                        <th class="text-end">Total Revenue</th>
                                        <th class="text-end">Avg Order Value</th>
                                        <th class="text-end">% of Total Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($booking_channels)):
                                        $totalChannelRevenue = array_sum(array_column($booking_channels, 'revenue'));
                                        foreach ($booking_channels as $channel):
                                            $avgOrderValue = $channel->count > 0 ? $channel->revenue / $channel->count : 0;
                                            $revenuePercentage = $totalChannelRevenue > 0 ? ($channel->revenue / $totalChannelRevenue) * 100 : 0;
                                    ?>
                                        <tr>
                                            <td>
                                                <strong><?= ucfirst(str_replace('_', ' ', esc($channel->booking_channel))); ?></strong>
                                            </td>
                                            <td class="text-end"><?= number_format($channel->count); ?></td>
                                            <td class="text-end"><strong>RM <?= number_format($channel->revenue, 2); ?></strong></td>
                                            <td class="text-end">RM <?= number_format($avgOrderValue, 2); ?></td>
                                            <td class="text-end">
                                                <span class="badge badge-success"><?= number_format($revenuePercentage, 1); ?>%</span>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No booking data available</td>
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
