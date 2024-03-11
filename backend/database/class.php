<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    // Generate
    public function generateId($firstCharacters, $lengthOfNumber)
    {
        $randomNumber = mt_rand(pow(10, $lengthOfNumber - 1), pow(10, $lengthOfNumber) - 1);
        $generatedId = $firstCharacters . '-' . $randomNumber;

        return $generatedId;
    }

    public function checkGeneratedId($table, $column, $id)
    {
        $query = $this->conn->prepare("SELECT * FROM `$table` WHERE `$column` = '$id'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    // accounts
    public function getUserUsingUsername($username)
    {
        $query = $this->conn->prepare("SELECT * FROM `accounts` WHERE `username` = '$username'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getUserUsingId($id)
    {
        $query = $this->conn->prepare("SELECT * FROM `accounts` WHERE `acc_id` = '$id'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function signIn($post, $file)
    {
        $accountId = $this->generateId("ACC", 8);
        while ($this->checkGeneratedId("accounts", "acc_id", $accountId)->num_rows > 0) {
            $accountId = $this->generateId("ACC", 8);
        }

        if ($this->checkGeneratedId('accounts', 'username', $post['username'])->num_rows > 0) {
            return 404;
        }

        $query = $this->conn->prepare("INSERT INTO `accounts`(`acc_id`, `acc_type`, `username`, `password`, `name`, `address`, `email`, `contact_no`, `valid_id`, `status`) VALUES ('$accountId','passenger','" . $post['username'] . "','" . $post['password'] . "','" . $post['name'] . "','" . $post['address'] . "','" . $post['email'] . "','" . $post['contact_no'] . "','','active')");
        if ($query->execute()) {
            return 200;
        } else {
            return "Hoyy";
        }

        // if (!empty($_FILES['validId']['size'])) {
        //     $file_name = $file['name'];
        //     $file_tmp = $file['tmp_name'];
        //     $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        //     $destinationDirectory = realpath(__DIR__ . '/../valid-id/') . '/';
        //     $newFileName = $accountId . '.' . $extension;
        //     $destination = $destinationDirectory . $newFileName;
        //     if (is_uploaded_file($file_tmp)) {
        //         if (move_uploaded_file($file_tmp, $destination)) {
        //             $query = $this->conn->prepare("INSERT INTO `accounts`(`acc_id`, `acc_type`, `username`, `password`, `name`, `address`, `email`, `contact_no`, `valid_id`, `status`) 
        //                                           VALUES ('$accountId','passenger','" . $post['username'] . "','" . $post['password'] . "','" . $post['name'] . "','" . $post['address'] . "','" . $post['email'] . "','" . $post['contact_no'] . "','$newFileName','active')");
        //             if ($query->execute()) {
        //                 $result = $query->get_result();
        //                 return $result;
        //             }
        //         } else {
        //             return $destination;
        //         }
        //     } else {
        //         return "Error: File upload failed or file not found.";
        //     }
        // } else {
        //     return 'File is empty';
        // }
    }

    public function editProfile($id, $post)
    {
        if ($getUser = $this->checkGeneratedId('accounts', 'username', $post['username'])) {
            if ($getUser->num_rows > 0) {
                $user = $getUser->fetch_assoc();
                if ($user['acc_id'] != $id) {
                    return 404;
                }
            }
        }

        $query = $this->conn->prepare("UPDATE `accounts` SET `username`='" . $post['username'] . "',`name`='" . $post['name'] . "',`address`='" . $post['address'] . "',`email`='" . $post['email'] . "',`contact_no`='" . $post['contact_no'] . "' WHERE `acc_id` = '$id'");
        if ($query->execute()) {
            return 200;
        } else {
            return "Hoyy";
        }
    }

    // routes
    public function getRouteList()
    {
        $query = $this->conn->prepare("SELECT * FROM `routes`");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function addRoute($post)
    {
        $id = $this->generateId('R-ID', 5);
        while ($this->checkGeneratedId('routes', 'route_id', $id)->num_rows > 0) {
            $id = $this->generateId('RA-ID', 5);
        }

        $query = $this->conn->prepare("INSERT INTO `routes`(`route_id`, `origin`, `destination`) VALUES ('" . $id . "','" . $post['origin'] . "','" . $post['destination'] . "')");
        if ($query->execute()) {
            echo 200;
        }
    }

    public function getRoutes()
    {
        $query = $this->conn->prepare("SELECT ra.*, r.origin, r.destination, r.fare, b.plate_number 
                                       FROM `routes_available` AS ra
                                       LEFT JOIN `routes` AS r ON ra.route_id = r.route_id
                                       LEFT JOIN `bus` AS b ON ra.bus_id = b.bus_id");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function addRouteSched($post)
    {
        $id = $this->generateId('RA-ID', 10);
        while ($this->checkGeneratedId('routes_available', 'route_av_id', $id)->num_rows > 0) {
            $id = $this->generateId('RA-ID', 10);
        }

        $query = $this->conn->prepare("INSERT INTO `routes_available`(`route_av_id`, `route_id`, `bus_id`, `date_departure`, `date_arrival`, `added_passenger`,`status`) VALUES ('$id','" . $post['routeId'] . "','" . $post['busId'] . "','" . $post['departure'] . "','" . $post['arrival'] . "', 0,'Active')");
        if ($query->execute()) {
            echo 200;
        }
    }

    public function addSubRoute($post)
    {
        $id = $this->generateId("SR", 5);
        while ($this->checkGeneratedId('sub_routes', 'sr_id', $id)->num_rows > 0) {
            $id = $this->generateId("SR", 5);
        }

        $query = $this->conn->prepare("INSERT INTO `sub_routes`(`sr_id`, `route_id`, `origin`, `destination`, `fare`) VALUES ('$id','" . $post['routeId'] . "','" . $post['origin'] . "','" . $post['destination'] . "','" . $post['fare'] . "')");
        if ($query->execute()) {
            return 200;
        }
        return "asd";
    }

    // Bus
    public function getBus()
    {
        $query = $this->conn->prepare("SELECT * FROM `bus` WHERE `status` = '1'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function addBus($plateNumber)
    {
        $id = $this->generateId('BUS', 4);
        while ($this->checkGeneratedId('bus', 'bus_id', $id)->num_rows > 0) {
            $id = $this->generateId('BUS', 4);
        }

        if ($this->checkGeneratedId('bus', 'plate_number', $plateNumber)->num_rows > 0) {
            return 400;
        }

        $query = $this->conn->prepare("INSERT INTO `bus`(`bus_id`, `plate_number`, `status`) 
                                        VALUES ('$id','$plateNumber','1')");
        if ($query->execute()) {
            return 200;
        }
    }

    // Announcement
    public function getAnnouncement()
    {
        $query = $this->conn->prepare("SELECT * FROM `announ`");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function addAnnouncement($post)
    {
        $id = $this->generateId('ANCMNT', 4);
        while ($this->checkGeneratedId('announ', 'announ_id', $id)->num_rows > 0) {
            $id = $this->generateId('ANCMNT', 4);
        }

        $query = $this->conn->prepare("INSERT INTO `announ`(`announ_id`, `title`, `text`, `status`) 
                                                    VALUES ('$id','" . $post['title'] . "','" . $post['text'] . "','1')");
        if ($query->execute()) {
            return 200;
        }
    }

    // Discounts
    public function getDiscounts()
    {
        $query = $this->conn->prepare("SELECT * FROM `discounts`");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    // Booking
    public function checkSeatAvailabilily($schedId, $seat)
    {
        $query = $this->conn->prepare("SELECT bd.bd_id FROM `booking_details` AS bd
                                       JOIN `booking` AS b ON bd.booking_id = b.booking_id
                                       JOIN `routes_available` AS ra ON b.route_av_id = ra.route_av_id
                                       WHERE ra.route_av_id = '$schedId'
                                       AND bd.seat_no = '$seat'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function checkPendingBooking($accId)
    {
        $query = $this->conn->prepare("SELECT * FROM `booking` WHERE `acc_id` = '$accId' AND `status` = 'pending'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function book($accId, $post)
    {
        $bookingDate = new DateTime();
        $expirationDate = clone $bookingDate;
        $expirationDate->add(new DateInterval('PT24H'));;

        $bookingId = $this->generateId("BOOKING", 8);
        while ($this->checkGeneratedId("booking", "booking_id", $bookingId)->num_rows > 0) {
            $bookingId = $this->generateId("BOOKING", 8);
        }

        $bookingDetailsId = $this->generateId("BD", 10);
        while ($this->checkGeneratedId("booking_details", "bd_id", $bookingDetailsId)->num_rows > 0) {
            $bookingDetailsId = $this->generateId("BD", 10);
        }

        $getSubroute = $this->checkGeneratedId("sub_routes", "sr_id", $post['subRoute']);
        $subRoute = $getSubroute->fetch_assoc();

        $getDiscount = $this->checkGeneratedId("discounts", "discount_id", $post['discount']);
        if ($getDiscount->num_rows > 0) {
            $discount = $getDiscount->fetch_assoc();
            $discountPercentage = $discount['discount_percentage'];
        } else {
            $discountPercentage = 0;
        }

        // Computation;
        $fare = $subRoute['fare'];

        $computedDiscount = $fare * $discountPercentage;
        $computedFare = $fare - $computedDiscount;

        $checkPendingBooking = $this->checkPendingBooking($accId);
        if ($checkPendingBooking->num_rows > 0) {
            $pendingBooking = $checkPendingBooking->fetch_assoc();
            $pendingBookingId = $pendingBooking['booking_id'];
            if ($pendingBooking['route_av_id'] == $post['routeAvId']) {
                $insertBooking = $this->conn->prepare("INSERT INTO `booking_details`(`bd_id`, `booking_id`, `sr_id`, `discount_id`, `seat_no`, `computed_fare`) 
                                                        VALUES ('$bookingDetailsId','$pendingBookingId','" . $post['subRoute'] . "','" . $post['discount'] . "','" . $post['seat'] . "', '$computedFare')");
                if ($insertBooking->execute()) {
                    return 201;
                }
            } else {
                return 404;
            }
        } else {
            $insertBooking = $this->conn->prepare("INSERT INTO `booking`(`booking_id`, `route_av_id`, `acc_id`, `booking_date`, `booking_expiration`, `booking_type`, `status`) 
                                                                    VALUES ('$bookingId','" . $post['routeAvId'] . "','$accId','" . $bookingDate->format('Y-m-d H:i:s') . "','" . $expirationDate->format('Y-m-d H:i:s') . "','online','pending')");

            $insertBookingDetails = $this->conn->prepare("INSERT INTO `booking_details`(`bd_id`, `booking_id`, `sr_id`, `discount_id`, `seat_no`, `computed_fare`) 
                                                                                VALUES ('$bookingDetailsId','$bookingId','" . $post['subRoute'] . "','" . $post['discount'] . "','" . $post['seat'] . "', '$computedFare')");

            if ($insertBooking->execute() && $insertBookingDetails->execute()) {
                return 200;
            }
        }
    }

    public function getAllBookings()
    {
        $query = $this->conn->prepare("SELECT b.*, a.name FROM `booking` AS b JOIN `accounts` AS a ON b.acc_id = a.acc_id");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
}
