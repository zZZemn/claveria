<?php
include('components/header.php');
$getRoutesList = $db->getRouteList();
$getBus = $db->getBus();

if (isset($_GET['b_id'])) {
    $bookingId = $_GET['b_id'];
    $getBookingInfo = $db->getBookingInformation($bookingId);
    if ($getBookingInfo->num_rows > 0) {
        $bookingInfo = $getBookingInfo->fetch_assoc();
        echo $bookingInfo['booking_id'];
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
        <!-- <div class="top-contents-btns-container d-flex align-items-center">
            <button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#AddRouteSched">
                <i class="bi bi-plus-lg"></i>
                New Schedule
            </button>
        </div> -->
    </div>
    <div class="table-container">

    </div>
</div>
<?php
include('components/footer.php');
?>