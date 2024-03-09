<?php
include('components/header.php');

if (isset($_GET['ra_sched_id'])) {
    $schedId = $_GET['ra_sched_id'];
    $getSched = $db->checkGeneratedId('routes_available', 'route_av_id', $schedId);
    if ($getSched->num_rows > 0) {
        $sched = $getSched->fetch_assoc();

        $routeId = $sched['route_id'];
        $getRoute = $db->checkGeneratedId('routes', 'route_id', $routeId);
        $route = $getRoute->fetch_assoc();

        $getSubRoute = $db->checkGeneratedId('sub_routes', 'route_id', $routeId);

        $getDiscount = $db->getDiscounts();

        $seats = ["1", "2", "3" , "4", "5"];
    } else {
        header('Location: routes-shedules.php');
        exit;
    }
} else {
    header('Location: routes-shedules.php');
    exit;
}
?>
<div>
    <div class="top-contents-container d-flex align-items-center justify-content-between">
        <h2 id="page-title">Book</h2>
    </div>
    <div class="table-container">
        <div class="container card p-3">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="input-container">
                    <label>Schedule ID</label>
                    <input type="text" class="form-control" value="<?= $sched['route_av_id'] ?>" readonly>
                </div>
                <div class="input-container">
                    <label>Bus</label>
                    <input type="text" class="form-control" value="<?= $sched['bus_id'] ?>" readonly>
                </div>
            </div>
            <div class="d-flex justify-content-between flex-wrap">
                <div class="input-container">
                    <label>Origin</label>
                    <input type="text" class="form-control" value="<?= $route['origin'] ?>" readonly>
                </div>
                <div class="input-container">
                    <label>Departure</label>
                    <input type="text" class="form-control" value="<?= $sched['date_departure'] ?>" readonly>
                </div>
            </div>
            <div class="d-flex justify-content-between flex-wrap">
                <div class="input-container">
                    <label>Destination</label>
                    <input type="text" class="form-control" value="<?= $route['destination'] ?>" readonly>
                </div>
                <div class="input-container">
                    <label>Arrival</label>
                    <input type="text" class="form-control" value="<?= $sched['date_arrival'] ?>" readonly>
                </div>
            </div>
            <div class="d-flex justify-content-between flex-wrap">
                <div class="input-container">
                    <label>Fare</label>
                    <input type="text" class="form-control" value="<?= $route['fare'] ?>" readonly>
                </div>
                <div class="input-container">
                    <label>Available</label>
                    <input type="text" class="form-control" value="50" readonly>
                </div>
            </div>
        </div>

        <hr>

        <div class="d-flex justify-content-between flex-wrap">
            <div class="">
                <div class="text-primary">
                    <span class="color-guide bg-primary px-1 mx-1"> s </span>
                    Seat Occupied
                </div>
                <table class="table-bordered table-bus-seats mt-2">
                    <tr>
                        <td class="bg-primary text-light"><span>1</span></td>
                        <td><span>2</span></td>
                        <td><span>-</span></td>
                        <td><span>3</span></td>
                        <td><span>4</span></td>
                    </tr>
                    <tr>
                        <td><span>5</span></td>
                        <td><span>6</span></td>
                        <td><span>-</span></td>
                        <td><span>7</span></td>
                        <td><span>8</span></td>
                    </tr>
                    <tr>
                        <td><span>9</span></td>
                        <td><span>10</span></td>
                        <td><span>-</span></td>
                        <td><span>11</span></td>
                        <td><span>12</span></td>
                    </tr>
                    <tr>
                        <td><span>13</span></td>
                        <td><span>14</span></td>
                        <td><span>-</span></td>
                        <td><span>15</span></td>
                        <td><span>16</span></td>
                    </tr>
                    <tr>
                        <td><span>17</span></td>
                        <td><span>18</span></td>
                        <td><span>-</span></td>
                        <td><span>19</span></td>
                        <td><span>20</span></td>
                    </tr>
                    <tr>
                        <td><span>21</span></td>
                        <td><span>22</span></td>
                        <td><span>-</span></td>
                        <td><span>23</span></td>
                        <td><span>24</span></td>
                    </tr>
                    <tr>
                        <td><span>25</span></td>
                        <td><span>26</span></td>
                        <td><span>-</span></td>
                        <td><span>27</span></td>
                        <td><span>28</span></td>
                    </tr>
                    <tr>
                        <td><span>29</span></td>
                        <td><span>30</span></td>
                        <td><span>-</span></td>
                        <td><span>31</span></td>
                        <td><span>32</span></td>
                    </tr>
                    <tr>
                        <td><span>33</span></td>
                        <td><span>34</span></td>
                        <td><span>-</span></td>
                        <td><span>35</span></td>
                        <td><span>36</span></td>
                    </tr>
                    <tr>
                        <td><span>37</span></td>
                        <td><span>38</span></td>
                        <td><span>39</span></td>
                        <td><span>40</span></td>
                        <td><span>41</span></td>
                    </tr>
                </table>
            </div>
            <div class="booking-card-container card p-3">
                <h6 class="text-center">Book Here!</h6>
                <div class="frm-add-booking">
                    <div class="input-container">
                        <label for="selectRoute">Pick Route</label>
                        <select id="selectRoute" class="form-control" required>
                            <option></option>
                            <?php
                            while ($subRoute = $getSubRoute->fetch_assoc()) {
                                echo "<option value='" . $subRoute['sr_id'] . "'>" . $subRoute['origin'] . ' To ' . $subRoute['destination'] . ' (' . $subRoute['fare'] . ")</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <div class="input-container">
                            <label for="selectDiscount">Discount</label>
                            <select id="selectDiscount" class="form-control" required>
                                <option value="None">None</option>
                                <?php
                                while ($discount = $getDiscount->fetch_assoc()) {
                                    echo "<option value=" . $discount['disount_id'] . ">" . $discount['discount_type'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-container">
                            <label for="selectSeat">Select Seat</label>
                            <select>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->

<!-- End of Modals -->
<?php
include('components/footer.php');
?>