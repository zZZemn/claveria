<?php
include('components/header.php');
$getRoutesList = $db->getRouteList();
$getBus = $db->getBus();

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
                <form id="frmAddBooking" class="frm-add-booking d-flex flex-column align-items-center">
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
                        <div class="input-container">
                            <label for="bookBy">Name</label>
                            <input type="text" id="bookBy" class="form-control" name="bookBy" required>
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
                            <input type="hidden" name="routeAvId" value="<?= $schedId ?>">
                            <input type="hidden" name="submitType" value="Book">
                            <button class="btn btn-primary">Add Booking</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modals -->

<!-- End of Modals -->
<?php
include('components/footer.php');
?>