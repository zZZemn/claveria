<?php
include('components/header.php');
$getRoutesList = $db->getRouteList();
$getBus = $db->getBus();

if (isset($_GET['b_id'])) {
    $bookingId = $_GET['b_id'];
    $getBookingInfo = $db->getBookingInformation($bookingId);
    if ($getBookingInfo->num_rows > 0) {
        $bookingInfo = $getBookingInfo->fetch_assoc();
        $getBookingDetails = $db->getBookingDetails($bookingId);
        $getAccount = $db->checkGeneratedId('accounts', 'acc_id', $bookingInfo['acc_id']);
    } else {
        header('Location: booking.php');
        exit();
    }
} else {
    header('Location: booking.php');
    exit();
}
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Bookings Details</h2>
        <div class="top-contents-btns-container d-flex align-items-center <?= ($bookingInfo['booking_status'] == 'Paid') ? 'd-none' : '' ?>">
            <button type="button" class="btn btn-primary mx-1" id="MarkAsPaid" data-id="<?= $bookingId ?>">
                <i class="bi bi-check2-all"></i>
                Mark as Paid
            </button>
        </div>
    </div>
    <div class="table-container">
        <div class="container card p-3 mt-2">
            <h5 class="text-center mt-1">Booking Details</h5>
            <hr>
            <div class="d-flex flex-wrap justify-content-between">
                <div class="input-container">
                    <label>Booking ID</label>
                    <input type="text" class="form-control" value="<?= $bookingInfo['booking_id'] ?>" readonly>
                </div>
                <div class="input-container">
                    <label>Booking Type</label>
                    <input type="text" class="form-control" value="<?= $bookingInfo['booking_type'] ?>" readonly>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-between">
                <div class="input-container">
                    <label>Booking Date</label>
                    <input type="text" class="form-control" value="<?= $bookingInfo['booking_date'] ?>" readonly>
                </div>
                <div class="input-container">
                    <label>Expiration Date</label>
                    <input type="text" class="form-control" value="<?= $bookingInfo['booking_expiration'] ?>" readonly>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-between">
                <div class="input-container">
                    <label>Book By</label>
                    <input type="text" class="form-control" value="<?= ($getAccount->num_rows > 0 ? $bookingInfo['name'] : $bookingInfo['acc_id']) ?>" readonly>
                </div>
                <div class="input-container">
                    <label>Status</label>
                    <input type="text" class="form-control" value="<?= $bookingInfo['booking_status'] ?>" readonly>
                </div>
            </div>
        </div>
        <div class="container card p-3 mt-3">
            <h5 class="text-center mt-1">Route Details</h5>
            <hr>
            <div>
                <div class="input-container">
                    <label>Departure Date</label>
                    <input type="text" class="form-control" value="<?= $bookingInfo['date_departure'] ?>" readonly>
                </div>
                <div class="input-container">
                    <label>Arrival Date</label>
                    <input type="text" class="form-control" value="<?= $bookingInfo['date_arrival'] ?>" readonly>
                </div>
            </div>
        </div>
        <div class="card container mt-3">
            <h5 class="text-center mt-4">Fare</h5>
            <hr>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Route</th>
                        <th>Discount</th>
                        <th>Seat No.</th>
                        <th>Fare</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($bookingDetail = $getBookingDetails->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $bookingDetail['origin'] . " To " . $bookingDetail['destination'] .  "</td>
                                <td>" . ($bookingDetail['discount_id'] != ' None' ? $bookingDetail['discount_type'] : 'None') . "</td>
                                <td>" . $bookingDetail['seat_no'] . "</td>
                                <td>" . $bookingDetail['computed_fare'] . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include('components/footer.php');
?>