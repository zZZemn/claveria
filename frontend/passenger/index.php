<?php
include('components/header.php');
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Announcements</h2>
    </div>
    <div class="table-container container mt-2">
        <?php
        $getAnnouncements = $db->getAnnouncement();
        while ($announcement = $getAnnouncements->fetch_assoc()) {
            echo "<div class='card p-3 mt-2'>
                    <h5 class='text-info mt-2'>" . $announcement['title'] . "</h5>
                    <hr>
                    <p class='text-secondary'>" . $announcement['text'] . "</p>
                  </div>";
        }
        ?>
    </div>
</div>

<!-- Modals -->

<!-- End of Modals -->
<?php
include('components/footer.php');
?>

<script>
    $('#nav-announcement').addClass('side-bar-active');
</script>