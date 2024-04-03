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
    <div class="print-only">
        <center>
            <h3>Claveria Bus Inc.</h3>
            <h6>Operated by Claveria Tours</h6>
            <h6>Siam-Siam Kilkiling Claveria Cagayan</h6>
        </center>
        <div class="container d-flex justify-content-center">
            <div class="">
                <h6>TERMS & CONDITION:</h6>
                <ul>
                    <li>This Reservation Slip is non-refundable.</li>
                    <li>Strictly no boarding/rebooking is allowed for lost reservation slip.</li>
                    <li>Request for rebooking shall only be allowed once.</li>
                    <li>Re-scheduling/Rebooking may be allowed only if the next reservation is not fully booked.</li>
                    <li>All passengers are expected to board 15minutes before the scheduled time of departure.</li>
                    <li>Always keep your Reservation Slip and/or Ticket while on board.</li>
                    <li>Present your Reservation Slip and/or Ticket upon inspection.</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title" class="print-d-none">Bookings Details</h2>
        <div class="top-contents-btns-container d-flex align-items-center print-d-none">
            <button type="button" class="btn btn-dark" id="cancelBooking" data-id="<?= $bookingId ?>">
                Cancel Booking
            </button>
            <button type="button" class="btn btn-primary mx-1 <?= ($bookingInfo['booking_status'] == 'Paid') ? 'd-none' : '' ?>" id="MarkAsPaid" data-id="<?= $bookingId ?>">
                <i class="bi bi-check2-all"></i>
                Mark as Paid
            </button>
            <button class="btn btn-primary" id="printBookingReceipt" onclick="window.print()">View Receipt</button>
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
        <div class="card container mt-3 <?= ($bookingInfo['booking_status'] == 'Paid') ? 'd-none' : '' ?> print-d-none">
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
                        <th>Actions</th>
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
                                <td>
                                    <button class='btn btn-danger btnDeleteBooking' data-id='" . $bookingDetail['bd_id'] . "'>Delete</button>
                                    <button class='btn btn-dark btnEditBooking' 
                                    data-id='" . $bookingDetail['bd_id'] . "'
                                    data-sr_id='" . $bookingDetail['sr_id'] . "'
                                    data-discount_id='" . $bookingDetail['discount_id'] . "'
                                    data-seat_no='" . $bookingDetail['seat_no'] . "'
                                    '>Edit</button>
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="EditBooking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Booking</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEditBooking">
                    <div class="input-container">
                        <label for="selectRoute">Pick Route</label>
                        <select id="editSelectRoute" class="form-control" name="subRoute" required>
                            <option></option>
                            <?php
                            $getSubRoute = $db->checkGeneratedId('sub_routes', 'route_id', $bookingInfo['route_id']);
                            while ($subRoute = $getSubRoute->fetch_assoc()) {
                                echo "<option value='" . $subRoute['sr_id'] . "'>" . $subRoute['origin'] . ' To ' . $subRoute['destination'] . ' (' . $subRoute['fare'] . ")</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-container">
                        <label for="selectDiscount">Discount</label>
                        <select id="editSelectDiscount" class="form-control" name="discount" required>
                            <option value=" None">None</option>
                            <?php
                            $getDiscount = $db->getDiscounts();
                            while ($discount = $getDiscount->fetch_assoc()) {
                            ?>
                                <option value="<?= $discount['discount_id'] ?>"><?= $discount['discount_type'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-container">
                        <label for="selectSeat"> Select Seat </label>
                        <select id="editSelectSeat" class="form-control" name="seat" required>
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
                    <div class="modal-footer">
                        <input type="hidden" name="bdId" id="editBookingId" value="">
                        <input type="hidden" name="submitType" value="EditBooking">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include('components/footer.php');
?>