<?php
include('components/header.php');
$getRoutesList = $db->getRouteList();
$getBus = $db->getBus();

function checkSeat($db, $schedId, $seat)
{
    $checkSeat = $db->checkSeatAvailabilily($schedId, $seat);
    if ($checkSeat->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET['b_id'])) {
    $bookingId = $_GET['b_id'];
    $getBookingInfo = $db->getBookingInformation($bookingId);
    if ($getBookingInfo->num_rows > 0) {
        $bookingInfo = $getBookingInfo->fetch_assoc();
        $getBookingDetails = $db->getBookingDetails($bookingId);
        $getAccount = $db->checkGeneratedId('accounts', 'acc_id', $bookingInfo['acc_id']);


        $getSubRoute = $db->checkGeneratedId('sub_routes', 'route_id', $bookingInfo['route_id']);
        $getDiscount = $db->getDiscounts();

        $seats = [
            "D1W", "D2W", "C2W", "C1W",
            "D3W", "D4A", "C4A", "C3W",
            "D5W", "D6A", "C6A", "C5W",
            "D7W", "D8A", "C8A", "C7W",
            "D9W", "D10A", "C10A", "C9W",
            "D11W", "D12A", "C12A", "C11W",
            "D13W", "D14A", "C14A", "C13W",
            "D15W", "D16A", "C16A", "C15W",
            "D17W", "D18A", "C18A", "C17W",
            "D19W", "D20A", "B21C", "C20A", "C19W"
        ];

        $schedId = $bookingInfo['route_av_id'];
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
        <div class="card container mt-3 <?= ($bookingInfo['booking_status'] == 'Paid') ? 'd-none' : '' ?>">
            <h5 class="text-center mt-4">Book Here</h5>
            <hr>
            <div class="d-flex justify-content-center">
                <?php include("seat-template.php"); ?>
            </div>
            <hr>
            <form id="frmAddNewBooking" class="frm-add-booking d-flex flex-column align-items-center">
                <div class="d-flex flex-wrap">
                    <div class="input-container" style="margin-right: 10px;">
                        <label for="selectRoute">Pick Route</label>
                        <select id="selectRoute" class="form-control" name="subRoute" required>
                            <option></option>
                            <?php
                            while ($subRoute = $getSubRoute->fetch_assoc()) {
                                echo "<option value='" . $subRoute['sr_id'] . "'>" . $subRoute['origin'] . ' To ' . $subRoute['destination'] . ' (' . $subRoute['fare'] . ")</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <div class="input-container" style="margin-right: 10px;">
                        <label for="selectDiscount">Discount</label>
                        <select id="selectDiscount" class="form-control" name="discount" required style="width: 130px;">
                            <option value=" None">None</option>
                            <?php
                            while ($discount = $getDiscount->fetch_assoc()) {
                                echo "<option value=" . $discount['discount_id'] . ">" . $discount['discount_type'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-container" style="margin-right: 10px;">
                        <label for="selectSeat">Select Seat</label>
                        <select id="selectSeat" class="form-control" name="seat" required style="width: 130px;">
                            <option value=""></option>
                            <?php
                            foreach ($seats as $seat) {
                                $checkIfSeatIsOccupied = $db->checkSeatAvailabilily($schedId, $seat);
                                if ($checkIfSeatIsOccupied->num_rows < 1) {
                                    echo "<option value=" . $seat . ">" . $seat . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="">
                        <input type="hidden" name="bookingId" value="<?= $bookingId ?>">
                        <input type="hidden" name="routeAvId" value="<?= $schedId ?>">
                        <input type="hidden" name="submitType" value="AddBook">
                        <button class="btn btn-primary">Add Booking</button>
                    </div>
                </div>
            </form>
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