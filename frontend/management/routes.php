<?php
include('components/header.php');
$getRoutesList = $db->getRouteList();
$getBus = $db->getBus();
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Routes</h2>
        <div class="top-contents-btns-container d-flex align-items-center">
            <button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#AddRoute">
                <i class="bi bi-plus-lg"></i> New Route
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getRoutesList = $db->getRouteList();
                while ($route = $getRoutesList->fetch_assoc()) {
                    echo "
                <tr>
                    <td>" . $route['route_id'] . "</td>
                    <td>" . $route['origin'] . "</td>
                    <td>" . $route['destination'] . "</td>
                    <td>" . $route['fare'] . "</td>
                    <td><button class='btn btn-primary'><i class='bi bi-pen'></i></button></td>
                </tr>
                ";
                }

                echo ($getRoutesList->num_rows < 1) ? '<tr><td colspan="9" class="text-center p-5">No route found.</td></tr>' : '';
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="AddRoute" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Route</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAddRoute">
                    <div class="input-container">
                        <label for="addROrigin">Origin</label>
                        <input type="text" id="addROrigin" name="origin" class="form-control" required>
                    </div>
                    <div class="input-container">
                        <label for="addRDestination">Destination</label>
                        <input type="text" id="addRDestination" name="destination" class="form-control" required>
                    </div>
                    <div class="input-container">
                        <label for="addRFare">Fare</label>
                        <input type="number" id="addRFare" name="fare" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="submitType" value="AddRoute">
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
    $('#nav-routes').addClass('side-bar-active');
</script>