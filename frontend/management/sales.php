<?php
include('components/header.php');
$getRoutesList = $db->getRouteList();
$getBus = $db->getBus();
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Sales</h2>
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
                    <th>ID</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getRoutes = $db->getRoutes();
                while ($route = $getRoutes->fetch_assoc()) {
                    $getAmountSales = $db->getComputedSales($route['route_av_id']);
                    $computedSales = $getAmountSales->fetch_assoc();
                    $amount = $computedSales['amount'];
                    echo "
                        <tr>
                            <td>" . $route['route_av_id'] . "</td>
                            <td>" . $route['origin'] . "</td>
                            <td>" . $route['destination'] . "</td>
                            <td>₱ " . ($amount == '' ? '0' : $amount) . "</td>
                        </tr>
                ";
                }

                echo ($getRoutes->num_rows < 1) ? '<tr><td colspan="5" class="text-center p-5">No route found.</td></tr>' : '';
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
include('components/footer.php');
?>

<script>
    $('#nav-sales').addClass('side-bar-active');
</script>