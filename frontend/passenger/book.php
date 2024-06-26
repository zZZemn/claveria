<?php
include('components/header.php');

if (isset($_GET['ra_sched_id'])) {
    $schedId = $_GET['ra_sched_id'];
    $getSched = $db->checkGeneratedId('routes_available', 'route_av_id', $schedId);
    if ($getSched->num_rows > 0) {
        $sched = $getSched->fetch_assoc();

        $routeId = $sched['route_id'];
        $getRoute = $db->checkGeneratedId('routes', 'route_id', $routeId);
        $route = $getRoute->fetch_assoc();

        $getSubRoute = $db->checkGeneratedId('sub_routes', 'route_id', $routeId);

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

        $getPendingBooking = $db->checkPendingBooking($id);

        function checkSeat($db, $schedId, $seat)
        {
            $checkSeat = $db->checkSeatAvailabilily($schedId, $seat);
            if ($checkSeat->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        }
    } else {
        header('Location: routes-shedules.php');
        exit;
    }
} else {
    header('Location: routes-shedules.php');
    exit;
}
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Book</h2>
        <button type="button" class="btn btn-dark" id="cancelBooking" data-id="<?= $bookingId ?>">
            Cancel Booking
        </button>
    </div>
    <div class="table-container">
        <div class="container card p-3">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="input-container">
                    <label>Schedule ID</label>
                    <input type="text" class="form-control" value="<?= $sched['route_av_id'] ?>" readonly>
                </div>
                <div class="input-container">
                    <label>Bus</label>
                    <input type="text" class="form-control" value="<?= $sched['bus_id'] ?>" readonly>
                </div>
            </div>
            <div class="d-flex justify-content-between flex-wrap">
                <div class="input-container">
                    <label>Origin</label>
                    <input type="text" class="form-control" value="<?= $route['origin'] ?>" readonly>
                </div>
                <div class="input-container">
                    <label>Departure</label>
                    <input type="text" class="form-control" value="<?= $sched['date_departure'] ?>" readonly>
                </div>
            </div>
            <div class="d-flex justify-content-between flex-wrap">
                <div class="input-container">
                    <label>Destination</label>
                    <input type="text" class="form-control" value="<?= $route['destination'] ?>" readonly>
                </div>
                <div class="input-container">
                    <label>Arrival</label>
                    <input type="text" class="form-control" value="<?= $sched['date_arrival'] ?>" readonly>
                </div>
            </div>
        </div>

        <hr>

        <div class="d-flex flex-column align-items-center">
            <div class="">
                <div class="text-primary">
                    <span class="color-guide bg-primary px-1 mx-1"> s </span>
                    Seat Occupied
                </div>
                <?php include('seat-template.php'); ?>
            </div>
            <div class="booking-card-container container card p-3 mt-3">
                <h6 class="text-center">Book Here!</h6>
                <form id="frmAddBooking" class="frm-add-booking">
                    <div class="input-container">
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
                            <input type="hidden" name="routeAvId" value="<?= $schedId ?>">
                            <input type="hidden" name="submitType" value="Book">
                            <button class="btn btn-primary">Add Booking</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php
            if ($getPendingBooking->num_rows > 0) {
                $pendingBooking = $getPendingBooking->fetch_assoc();
                if ($pendingBooking['route_av_id'] == $schedId) {
                    $bookingId = $pendingBooking['booking_id'];
            ?>
                    <div class="container card p-3 mt-3">
                        <h4 class="text-center mt-2">Your Booking</h4>
                        <hr>
                        <div class="d-flex flex-wrap">
                            <div class="input-container" style="margin-right: 15px; width: 250px">
                                <label>Booking Date</label>
                                <input type="text" readonly class="form-control" value="<?= date('F j, Y, g:i A', strtotime($pendingBooking['booking_date'])) ?>">
                            </div>
                            <div class="input-container" style="width: 250px">
                                <label>Booking Expiration</label>
                                <input type="text" readonly class="form-control" value="<?= date('F j, Y, g:i A', strtotime($pendingBooking['booking_expiration'])) ?>">
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Route</th>
                                    <th>Seat no.</th>
                                    <th>Discount</th>
                                    <th>Computed Fare</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $getBookingDetails = $db->checkGeneratedId("booking_details", "booking_id", $bookingId);
                                while ($bd = $getBookingDetails->fetch_assoc()) {
                                    $getSubroute = $db->checkGeneratedId("sub_routes", "sr_id", $bd['sr_id']);
                                    $subroute = $getSubroute->fetch_assoc();

                                    $getDiscount = $db->checkGeneratedId("discounts", "discount_id", $bd['discount_id']);
                                    $discount = $getDiscount->fetch_assoc();

                                    echo "
                                           <tr>
                                               <td>" . $bd['bd_id'] . "</td>
                                               <td>" . $subroute['origin'] . ' To ' . $subroute['destination'] .  "</td>
                                               <td>" . $bd['seat_no'] . "</td>
                                               <td>" . (($getDiscount->num_rows > 0) ? $discount['discount_type'] : 'None') . "</td>
                                               <td>" . $bd['computed_fare'] . "</td>
                                               <td>
                                               <button class='btn btn-sm btn-dark btnEditBooking' 
                                                data-id='" . $bd['bd_id'] . "'
                                                data-sr_id='" . $bd['sr_id'] . "'
                                                data-discount_id='" . $bd['discount_id'] . "'
                                                data-seat_no='" . $bd['seat_no'] . "'
                                                '>
                                                Edit
                                                </button>
                                                    <button class='btn btn-sm btn-danger btnDelete' data-id='" . $bd['bd_id'] . "'>Delete</button>
                                               </td>
                                           </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>

</div>

<!-- Modals -->
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
                            $getSubRoute = $db->checkGeneratedId('sub_routes', 'route_id', $routeId);
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
<!-- End of Modals -->
<?php
include('components/footer.php');
?>