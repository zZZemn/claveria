<?php
include('components/header.php');
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Profile</h2>
        <div class="top-contents-btns-container d-flex align-items-center">
            <button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#EditProfile">
                <i class="bi bi-pencil-square"></i> Edit Profile
            </button>
        </div>
    </div>
    <div class="table-container container">
        <hr>
        <div class="input-container">
            <label>Name</label>
            <input type="text" readonly class="form-control" value="<?= $account['name'] ?>">
        </div>
        <div class="input-container">
            <label>Username</label>
            <input type="text" readonly class="form-control" value="<?= $account['username'] ?>">
        </div>
        <div class="input-container">
            <label>Email</label>
            <input type="text" readonly class="form-control" value="<?= $account['email'] ?>">
        </div>
        <div class="input-container">
            <label>Contact no.</label>
            <input type="text" readonly class="form-control" value="<?= $account['contact_no'] ?>">
        </div>
        <div class="input-container">
            <label>Address</label>
            <textarea readonly class="form-control"><?= $account['address'] ?></textarea>
        </div>
    </div>
</div>

<!-- Modals -->

<!-- End of Modals -->
<?php
include('components/footer.php');
?>

<script>
    $('#nav-profile').addClass('side-bar-active');
</script>