<!-- Add Route Schedule -->
<div class="modal fade" id="AddRouteSched" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Route Schedule</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAddRouteSched">
                    <div class="input-container">
                        <label for="addRoute">Route</label>
                        <select id="addRoute" name="routeId" class="form-control" required>
                            <option></option>
                            <?php
                            while ($route = $getRoutesList->fetch_assoc()) {
                                echo "<option value=" . $route['route_id'] . ">" . $route['origin'] . " To " . $route['destination'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-container">
                        <label for="addBus">Bus</label>
                        <select id="addBus" name="busId" class="form-control" required>
                            <option></option>
                            <?php
                            while ($bus = $getBus->fetch_assoc()) {
                                echo "<option value=" . $bus['bus_id'] . ">" . $bus['plate_number'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-container">
                        <label for="addDeparture">Departure</label>
                        <input type="datetime-local" id="addDeparture" name="departure" class="form-control" required>
                    </div>
                    <div class="input-container">
                        <label for="addArrival">Arrival</label>
                        <input type="datetime-local" id="addArrival" name="arrival" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="submitType" value="AddRouteSched">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Add Route Schedule -->

<!-- Add Route -->
<div class="modal fade" id="AddRoute" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Route</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAddRoute">
                    <div class="input-container">
                        <label for="addROrigin">Origin</label>
                        <input type="text" id="addROrigin" name="origin" class="form-control" required>
                    </div>
                    <div class="input-container">
                        <label for="addRDestination">Destination</label>
                        <input type="text" id="addRDestination" name="destination" class="form-control" required>
                    </div>
                    <!-- <div class="input-container">
                        <label for="addRFare">Fare</label>
                        <input type="number" id="addRFare" name="fare" class="form-control" required>
                    </div> -->
                    <div class="modal-footer">
                        <input type="hidden" name="submitType" value="AddRoute">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Add Route -->

<!-- Add Bus -->
<div class="modal fade" id="AddBus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Bus</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAddBus">
                    <div class="input-container">
                        <label for="addBusPlateNumber">Plate Number</label>
                        <input type="text" id="addBusPlateNumber" name="plateNumber" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="submitType" value="AddBus">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Add Bus -->

<!-- Add Inspector -->
<div class="modal fade" id="AddInspector" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Inspector</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAddInspector">
                    <div class="input-container">
                        <label for="addInspectorUsername">Username</label>
                        <input type="text" id="addInspectorUsername" name="username" class="form-control" required>
                    </div>
                    <div class="input-container">
                        <label for="addInspectorPassword">Password</label>
                        <input type="password" id="addInspectorPassword" name="password" class="form-control" required>
                    </div>
                    <div class="input-container">
                        <label for="addInspectorName">Name</label>
                        <input type="text" id="addInspectorName" name="name" class="form-control" required>
                    </div>
                    <div class="input-container">
                        <label for="addInspectorAddress">Address</label>
                        <input type="text" id="addInspectorAddress" name="address" class="form-control" required>
                    </div>
                    <div class="input-container">
                        <label for="addInspectorEmail">Email</label>
                        <input type="email" id="addInspectorEmail" name="email" class="form-control" required>
                    </div>
                    <div class="input-container">
                        <label for="addInspectorContactNo">Contact No</label>
                        <input type="number" id="addInspectorContactNo" name="contact_no" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="submitType" value="AddInspector">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Add Inspector -->