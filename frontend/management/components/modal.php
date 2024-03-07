<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>
</div> -->


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