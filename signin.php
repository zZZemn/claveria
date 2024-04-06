<?php
include("global-components/header.php");
?>
<form id="frmSignin" class="sign-in-main-container card container mt-5 mb-5">
    <h3 class="text-center text-secondary mt-5">Sign in</h3>
    <div class="si-f-row mt-2">
        <div class="input-container">
            <label for="sName">Name</label>
            <input type="text" id="sName" name="name" class="form-control" required>
            <div class="invalid-feedback">Please enter a valid name.</div>
        </div>
    </div>
    <div class="input-container mt-2">
        <label for="sEmail">Email</label>
        <input type="email" id="sEmail" name="email" class="form-control" required>
        <div class="invalid-feedback">Please enter a valid email.</div>
    </div>
    <div class="input-container mt-2">
        <label for="sContactNo">Contact no.</label>
        <input type="number" id="sContactNo" name="contact_no" class="form-control" required>
        <div class="invalid-feedback">Please enter a valid contact number. (11 digits)</div>
    </div>
    <div class="si-fo-row mt-2 mt-2">
        <div class="input-container">
            <label for="sAddress">Address</label>
            <input type="text" id="sAddress" name="address" class="form-control" required>
            <div class="invalid-feedback">Please enter address. (min of 15 characters)</div>
        </div>
    </div>
    <div class="input-container mt-2">
        <label for="sUsername">Username</label>
        <input type="username" id="sUsername" name="username" class="form-control" required>
        <div class="invalid-feedback">Please enter a username. (min of 7 characters)</div>
    </div>
    <div class="input-container mt-2">
        <label for="sPassword">Password</label>
        <input type="password" id="sPassword" name="password" class="form-control" required>
        <div class="invalid-feedback">Please enter a valid password. (min of 7 characters)</div>
    </div>
    <div class="si-fi-row mt-2 mt-2">
        <div class="input-container">
            <label for="sValidId">Valid ID</label>
            <input type="file" id="sValidId" name="validId" class="form-control" required>
            <div class="invalid-feedback">Please upload valid ID.</div>
        </div>
    </div>
    <div class="text-center mt-3 mb-3">
        <button class="btn btn-primary">Sign in</button>
    </div>
</form>
<?php
include("global-components/footer.php");
