<?php
include('components/header.php');
$getRoutesList = $db->getRouteList();
$getBus = $db->getBus();
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Routes Schedule</h2>
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
                    <th>Route ID</th>
                    <th>Bus</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Added Passenger</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getRoutes = $db->getRoutes();
                while ($route = $getRoutes->fetch_assoc()) {
                    echo "
                <tr>
                    <td>" . $route['route_av_id'] . "</td>
                    <td>" . $route['plate_number'] . "</td>
                    <td>" . $route['origin'] . "</td>
                    <td>" . $route['destination'] . "</td>
                    <td>" . $route['date_departure'] . "</td>
                    <td>" . $route['date_arrival'] . "</td>
                    <td>" . $route['added_passenger'] . "</td>
                    <td>" . $route['status'] . "</td>
                    <td>
                        <button class='btn btn-primary btn-add-passenger' data-id='" . $route['route_av_id'] . "'>
                            <i class='bi bi-plus-lg'></i> Add Passenger
                        </button>
                    </td>
                </tr>
                ";
                }

                echo ($getRoutes->num_rows < 1) ? '<tr><td colspan="9" class="text-center p-5">No route found.</td></tr>' : '';
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="AddPassenger" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Passenger to <span id="addPassengerRouteId"></span></h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAddInspector">
                    <div class="input-container">
                        <label for="numberOfPassenger">Number of Added Passenger</label>
                        <input type="number" id="numberOfPassenger" name="addedPassenger" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="submitType" value="AddPassenger">
                        <input type="hidden" name="subRouteId" id="subRouteId" value="">
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

<script>
    $('#nav-routes-schedules').addClass('side-bar-active');
</script>