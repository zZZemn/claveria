<?php
include('components/header.php');
$getRoutesList = $db->getRouteList();
$getBus = $db->getBus();

$getAnnouncement = $db->getAnnouncement();
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Announcements</h2>
        <div class="top-contents-btns-container d-flex align-items-center">
            <button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#AddAnnouncement">
                <i class="bi bi-plus-lg"></i> Announcement
            </button>
        </div>
    </div>
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Announcement&nbspID</th>
                    <th>Announcement</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($ann = $getAnnouncement->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $ann['announ_id'] . "</td>
                            <td><img style='height: 200px;' src='../../backend/announcement/" . $ann['img'] . "'></td>
                          </tr>";
                }

                echo ($getAnnouncement->num_rows < 1) ? '<tr><td colspan="3" class="text-center p-5">No announcement found.</td></tr>' : '';
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="AddAnnouncement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Announcement</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAddAnnouncement">
                    <div class="input-container">
                        <label for="addAnnouncement">Upload Announcement</label>
                        <input type="file" id="addAnnouncement" name="announcement" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="submitType" value="AddAnnouncement">
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
    $('#nav-announcement').addClass('side-bar-active');
</script>