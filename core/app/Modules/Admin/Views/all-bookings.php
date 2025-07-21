<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Esim Bookings</h6>
            <div class="d-flex">
                <!-- Status Filter Dropdown -->
                <div>
                    <label for="statusFilter" class="mr-2 font-weight-bold">Filter by Status:</label>
                    <select id="statusFilter" class="form-control d-inline-block w-auto">
                        <option value="">All</option>
                        <option value="Pending">Pending</option>
                        <option value="Active">Active</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <?php
                    $uri = service('uri');
                    $page = $uri->getSegment(2);
                ?>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>Ref No</th>
                    <?php if($page !== 'all-hotel-bookings') : ?>
                        <th>Bundle ID</th>
                        <th>Quantity</th>
                    <?php endif ?>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
           
            <tbody>
                
                
                <?php if (!empty($bookings)) : ?>
                    <?php foreach ($bookings as $booking) : ?>
                        <?php
                        $showBooking = false;

                        if ($page === 'all-hotel-bookings' && !empty($booking['booking_reference'])) {
                            $showBooking = true;
                        } elseif ($page === 'all-bookings' && !empty($booking['esim_reference'])) {
                            $showBooking = true;
                        }
                        ?>

                        <?php if ($showBooking) : ?>
                            <tr>
                                <td><?= esc($booking['id']) ?></td>
                                <td><?= esc($booking['user_name']) ?></td>
                                <td><a href="mailto:<?= esc($booking['user_email']) ?>"><?= esc($booking['user_email']) ?></a></td>
                                <td><?= esc($page === 'all-bookings' ? $booking['esim_reference'] : $booking['booking_reference']) ?></td>
                                <?php if($page !== 'all-hotel-bookings') : ?>
                                    <td><?= esc($booking['bundle_id'] ?? '-') ?></td>
                                    <td><?= esc($booking['quantity'] ?? '-') ?></td>
                                <?php endif ?>
                                <td><?= esc($booking['total_price']) ?> <?= esc($booking['currency']) ?></td>
                                <td><?= esc(ucfirst($booking['status'])) ?></td>
                                <td><?= esc($booking['created_at']) ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9">No bookings found.</td>
                    </tr>
                <?php endif; ?>
        </table>
    </div>
</div>
    </div>
</div>