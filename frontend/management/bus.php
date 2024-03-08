<?php
include('components/header.php');
$getRoutesList = $db->getRouteList();
$getBus = $db->getBus();
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Bus</h2>
        <div class="top-contents-btns-container d-flex align-items-center">
            <button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#AddBus">
                <i class="bi bi-plus-lg"></i> New Bus
            </button>
        </div>
    </div>
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Bus ID</th>
                    <th>Plate Number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($bus = $getBus->fetch_assoc()) {
                    echo "
                <tr>
                    <td>" . $bus['bus_id'] . "</td>
                    <td>" . $bus['plate_number'] . "</td>
                    <td>" . ($bus['status'] == 1 ? 'Active' : 'Not Active') . "</td>
                </tr>
                ";
                }

                echo ($getBus->num_rows < 1) ? '<tr><td colspan="9" class="text-center p-5">No bus found.</td></tr>' : '';
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
    $('#nav-bus').addClass('side-bar-active');
</script>