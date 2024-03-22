<?php
include('components/header.php');
$getRoutesList = $db->getRouteList();
$getBus = $db->getBus();
$getInspectors = $db->getUsers('inspector');
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Inspectors</h2>
        <div class="top-contents-btns-container d-flex align-items-center">
            <button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#AddInspector">
                <i class="bi bi-plus-lg"></i> New Inspector
            </button>
        </div>
    </div>
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Address</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Contact no.</td>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($inspector = $getInspectors->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $inspector['acc_id'] . "</td>
                            <td>" . $inspector['name'] . "</td>
                            <td>" . $inspector['address'] . "</td>
                            <td>" . $inspector['username'] . "</td>
                            <td>" . $inspector['email'] . "</td>
                            <td>" . $inspector['contact_no'] . "</td>
                          </tr>";
                }

                echo ($getInspectors->num_rows < 1) ? '<tr><td colspan="9" class="text-center p-5">No inspector found.</td></tr>' : '';
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
    $('#nav-inspector').addClass('side-bar-active');
</script>