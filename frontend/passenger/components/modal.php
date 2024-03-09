<!-- Edit Profile -->
<div class="modal fade" id="EditProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEditProfile">
                    <div class="si-f-row mt-2">
                        <div class="input-container">
                            <label for="editName">Name</label>
                            <input type="text" id="editName" name="name" class="form-control" value="<?= $account['name'] ?>" required>
                            <div class="invalid-feedback">Please enter a valid name.</div>
                        </div>
                    </div>
                    <div class="input-container mt-2">
                        <label for="editUsername">Username</label>
                        <input type="username" id="editUsername" name="username" class="form-control" value="<?= $account['username'] ?>" required>
                        <div class="invalid-feedback">Please enter a username. (min of 7 characters)</div>
                    </div>
                    <div class="input-container mt-2">
                        <label for="editEmail">Email</label>
                        <input type="email" id="editEmail" name="email" class="form-control" value="<?= $account['email'] ?>" required>
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>
                    <div class="input-container mt-2">
                        <label for="editContact">Contact no.</label>
                        <input type="number" id="editContact" name="contact_no" class="form-control" value="<?= $account['contact_no'] ?>" required>
                        <div class="invalid-feedback">Please enter a valid contact number. (11 digits)</div>
                    </div>
                    <div class="si-fo-row mt-2 mt-2">
                        <div class="input-container">
                            <label for="editAddress">Address</label>
                            <input type="text" id="editAddress" name="address" class="form-control" value="<?= $account['address'] ?>" required>
                            <div class="invalid-feedback">Please enter address. (min of 15 characters)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="submitType" value="EditProfile">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Edit Profile -->