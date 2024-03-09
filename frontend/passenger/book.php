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
            <div class="d-flex justify-content-between flex-wrap">
                <div class="input-container">
                    <label>Fare</label>
                    <input type="text" class="form-control" value="<?= $route['fare'] ?>" readonly>
                </div>
                <div class="input-container">
                    <label>Available</label>
                    <input type="text" class="form-control" value="50" readonly>
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