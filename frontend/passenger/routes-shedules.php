<?php
include('components/header.php');
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Routes Schedule</h2>
        <div class="top-contents-btns-container d-flex align-items-center">
            <button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#AddRouteSched">
                <i class="bi bi-plus-lg"></i>
                New Schedule
            </button>
        </div>
    </div>
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Route ID</th>
                    <th>Bus</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Fare</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getRoutes = $db->getRoutes();
                while ($route = $getRoutes->fetch_assoc()) {
                    if ($route['status'] == 'Active') {
                        echo "
                        <tr>
                            <td>" . $route['route_av_id'] . "</td>
                            <td>" . $route['plate_number'] . "</td>
                            <td>" . $route['origin'] . "</td>
                            <td>" . $route['destination'] . "</td>
                            <td>" . $route['fare'] . "</td>
                            <td>" . $route['date_departure'] . "</td>
                            <td>" . $route['date_arrival'] . "</td>
                            <td>" . $route['status'] . "</td>
                            <td>
                                <a href='book.php?ra_sched_id=" . $route['route_av_id'] . "' class='btn btn-primary'>Book</a>
                            </td>
                        </tr>
                        ";
                    }
                }

                echo ($getRoutes->num_rows < 1) ? '<tr><td colspan="9" class="text-center p-5">No route found.</td></tr>' : '';
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
    $('#nav-routes-schedules').addClass('side-bar-active');
</script>