<?php
include("global-components/header.php");
?>
<form id="frmLogin" class="login-main-container card container mt-5 mb-5">
    <h3 class="text-center text-secondary mt-5">Login</h3>
    <div class="login-input-container d-flex flex-column align-items-center mt-5">
        <div class="input-container">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" required>
            <div class="invalid-feedback">Please enter a valid username.</div>
        </div>
        <div class="input-container mt-2">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
            <div class="invalid-feedback">Please enter a password.</div>
        </div>
    </div>
    <div class="text-center mt-3 mb-3">
        <button class="btn btn-primary">Login</button>
    </div>
</form>
<?php
include("global-components/footer.php");
