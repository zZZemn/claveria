<?php
include('components/header.php');
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
                    <th>Booking Date</th>
                    <th>Booking Expiration</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getBookings = $db->checkGeneratedId("booking", "acc_id", $id);
                while ($booking = $getBookings->fetch_assoc()) {
                    echo "
                            <tr>
                                <td>" . $booking['booking_id'] . "</td>
                                <td>" . $booking['booking_date'] . "</td>
                                <td>" . $booking['booking_expiration'] . "</td>
                                <td>" . $booking['status'] . "</td>
                                <td>
                                    <a href='book.php?ra_sched_id=" . $booking['route_av_id'] . "' class='btn btn-primary'>View</a>
                                    <a href='ticket-printing.php?b_id=" . $booking['booking_id'] . "' class='btn btn-primary'>Booking Details</a>
                                </td>
                            </tr>
                            ";
                }

                // echo ($getRoutes->num_rows < 1) ? '<tr><td colspan="9" class="text-center p-5">No route found.</td></tr>' : '';
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modals -->

<!-- End of Modals -->
<?php
include('components/footer.php');
?>

<script>
    $('#nav-bookings').addClass('side-bar-active');
</script>