<?php
include('components/header.php');

if (isset($_GET['route_id'])) {
    $routeId = $_GET['route_id'];
    $checkRouteId = $db->checkGeneratedId('routes', 'route_id', $routeId);
    if ($checkRouteId->num_rows > 0) {
        $getSubRoutes = $db->checkGeneratedId('sub_routes', 'route_id', $routeId);
    } else {
        header("Location: routes.php");
        exit;
    }
} else {
    header("Location: routes.php");
    exit;
}

$getRoutesList = $db->getRouteList();
$getBus = $db->getBus();
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h5 id="page-title">Sub Routes of <?= $routeId ?></h5>
        <div class="top-contents-btns-container d-flex align-items-center">
            <button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#AddSubRoute">
                <i class="bi bi-plus-lg"></i> Sub Routes
            </button>
        </div>
    </div>
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Fare</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($subRoute = $getSubRoutes->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $subRoute['sr_id'] . "</td>
                            <td>" . $subRoute['origin'] . "</td>
                            <td>" . $subRoute['destination'] . "</td>
                            <td>" . $subRoute['fare'] . "</td>
                          </tr>";
                }

                echo ($getSubRoutes->num_rows < 1) ? '<tr><td colspan="4" class="text-center">No route found</td></tr>' : '';
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modals -->
<!-- Add Sub Route -->
<div class="modal fade" id="AddSubRoute" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Sub Routes</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAddSubRoute">
                    <div class="input-container">
                        <label for="addSROrigin">Origin</label>
                        <input type="text" id="addROrigin" name="origin" class="form-control" required>
                    </div>
                    <div class="input-container">
                        <label for="addSRDestination">Destination</label>
                        <input type="text" id="addRDestination" name="destination" class="form-control" required>
                    </div>
                    <div class="input-container">
                        <label for="addRFare">Fare</label>
                        <input type="number" id="addSRFare" name="fare" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="submitType" value="AddSubRoute">
                        <input type="hidden" name="routeId" id="addSRrouteId" value="<?= $routeId ?>">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Add Sub Route -->
<!-- End of Modals -->
<?php
include('components/footer.php');
?>