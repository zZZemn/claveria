<?php
include('components/header.php');
$getRoutesList = $db->getRouteList();
$getBus = $db->getBus();
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Bookings</h2>
        <!-- <div class="top-contents-btns-container d-flex align-items-center">
            <button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#AddRouteSched">
                <i class="bi bi-plus-lg"></i>
                New Schedule
            </button>
        </div> -->
    </div>
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Route</th>
                    <th>Name</th>
                    <th>Booking Date</th>
                    <th>Expiration Date</th>
                    <th>Booking Type</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sales = 0;
                $getAllBookings = $db->getAllBookings();
                while ($booking = $getAllBookings->fetch_assoc()) {
                    $getAccount = $db->checkGeneratedId('accounts', 'acc_id', $booking['acc_id']);
                    $getTotal = $db->getBookingAmount($booking['booking_id'])->fetch_assoc();
                    $sales += ($booking['status'] == 'Paid' ? $getTotal['total_amount'] : 0);
                    echo "<tr>
                            <td>" . $booking['booking_id'] . "</td>
                            <td>" . $booking['route_av_id'] . "</td>
                            <td>" . ($getAccount->num_rows > 0 ? $booking['name'] : $booking['acc_id']) . "</td>
                            <td>" . $booking['booking_date'] . "</td>
                            <td>" . $booking['booking_expiration'] . "</td>
                            <td>" . $booking['booking_type'] . "</td>
                            <td>₱ " . $getTotal['total_amount'] . "</td>
                            <td>" . ucfirst($booking['status']) . "</td>
                            <td><a href='booking-details.php?b_id=" . $booking['booking_id'] . "' class='btn btn-primary'>View</a></td>
                          </tr>";
                }

                $finalSales = '₱ ' . number_format($sales, 2);
                echo "<tr class='booking-sales'>
                        <td colspan='6' class='text-success'>Total Paid Bookings:</td>
                        <td colspan='2' class='text-success'>" . $finalSales . "</td>
                      <td>";

                echo ($getAllBookings->num_rows < 1) ? '<tr><td colspan="8" class="text-center p-5">No booking found.</td></tr>' : '';
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
include('components/footer.php');
?>

<script>
    $('#nav-booking').addClass('side-bar-active');
</script>