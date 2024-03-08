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

<!-- End of Modals -->
<?php
include('components/footer.php');
?>

<script>
    $('#nav-routes').addClass('side-bar-active');
</script>