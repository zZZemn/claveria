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

    public function addInspector($post)
    {
        $accountId = $this->generateId("ACC", 8);
        while ($this->checkGeneratedId("accounts", "acc_id", $accountId)->num_rows > 0) {
            $accountId = $this->generateId("ACC", 8);
        }

        if ($this->checkGeneratedId('accounts', 'username', $post['username'])->num_rows > 0) {
            return 404;
        }

        $query = $this->conn->prepare("INSERT INTO `accounts`(`acc_id`, `acc_type`, `username`, `password`, `name`, `address`, `email`, `contact_no`, `valid_id`, `status`) VALUES ('$accountId','inspector','" . $post['username'] . "','" . $post['password'] . "','" . $post['name'] . "','" . $post['address'] . "','" . $post['email'] . "','" . $post['contact_no'] . "','','active')");
        if ($query->execute()) {
            return 200;
        } else {
            return "Hoyy";
        }
    }

    public function getUsers($accType)
    {
        $query = $this->conn->prepare("SELECT * FROM `accounts` WHERE `acc_type` = '$accType'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
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
        return "asds";
    }

    public function addPassenger($post)
    {
        $query = $this->conn->prepare("UPDATE `routes_available` SET `added_passenger`= added_passenger + '" . $post['addedPassenger'] . "' WHERE `route_av_id` = '" . $post['subRouteId'] . "'");
        if ($query->execute()) {
            return 200;
        }
    }

    public function getComputedSales($routeAvId)
    {
        $query = $this->conn->prepare("SELECT b.booking_id, SUM(bd.computed_fare) AS amount
                                       FROM booking_details AS bd
                                       LEFT JOIN booking AS b ON b.booking_id = bd.booking_id
                                       WHERE b.route_av_id = '$routeAvId'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
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

    public function addAnnouncement($file)
    {
        $id = $this->generateId('ANCMNT', 4);
        while ($this->checkGeneratedId('announ', 'announ_id', $id)->num_rows > 0) {
            $id = $this->generateId('ANCMNT', 4);
        }

        if (!empty($_FILES['announcement']['size'])) {
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $destinationDirectory =  __DIR__ . '../../announcement/';
            $newFileName = $id . '.' . $extension;
            $destination = $destinationDirectory . $newFileName;
            if (is_uploaded_file($file_tmp)) {
                if (move_uploaded_file($file_tmp, $destination)) {
                    $query = $this->conn->prepare("INSERT INTO `announ`(`announ_id`, `img`,`title`, `text`, `status`) 
                                                    VALUES ('$id','$newFileName','', '','1')");
                    if ($query->execute()) {
                        return 200;
                    } else {
                        return $query;
                    }
                } else {
                    return "Error: File upload failed or file not found.";
                }
            } else {
                return 'File is empty';
            }
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

    /*public function book($accId, $post)
    {
        $bookingDate = new DateTime();
        $expirationDate = clone $bookingDate;
        $expirationDate->add(new DateInterval('PT24H'));;


        // Generate ID
        $bookingId = $this->generateId("BOOKING", 8);
        while ($this->checkGeneratedId("booking", "booking_id", $bookingId)->num_rows > 0) {
            $bookingId = $this->generateId("BOOKING", 8);
        }

        $bookingDetailsId = $this->generateId("BD", 10);
        while ($this->checkGeneratedId("booking_details", "bd_id", $bookingDetailsId)->num_rows > 0) {
            $bookingDetailsId = $this->generateId("BD", 10);
        }
        // End of Generate ID

        $getSubroute = $this->checkGeneratedId("sub_routes", "sr_id", $post['subRoute']);
        $subRoute = $getSubroute->fetch_assoc();

        $getDiscount = $this->checkGeneratedId("discounts", "discount_id", $post['discount']);
        if ($getDiscount->num_rows > 0) {
            $discount = $getDiscount->fetch_assoc();
            $discountPercentage = $discount['discount_percentage'];
        } else {
            $discountPercentage = 0;
        }

        // User Details
        $getUser = $this->checkGeneratedId("accounts", "acc_id", $accId);
        $userDetails = $getUser->fetch_assoc();
        $userEmail = $userDetails['email'];
        $userName = $userDetails['name'];
        // End of User Details

        // Computation;
        $fare = $subRoute['fare'];

        $computedDiscount = $fare * $discountPercentage;
        $computedFare = $fare - $computedDiscount;
        // End of Computation

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
            // Email sending

            // End of email sending

            $insertBooking = $this->conn->prepare("INSERT INTO `booking`(`booking_id`, `route_av_id`, `acc_id`, `booking_date`, `booking_expiration`, `booking_type`, `status`) 
                                                                    VALUES ('$bookingId','" . $post['routeAvId'] . "','$accId','" . $bookingDate->format('Y-m-d H:i:s') . "','" . $expirationDate->format('Y-m-d H:i:s') . "','online','pending')");

            $insertBookingDetails = $this->conn->prepare("INSERT INTO `booking_details`(`bd_id`, `booking_id`, `sr_id`, `discount_id`, `seat_no`, `computed_fare`) 
                                                                                VALUES ('$bookingDetailsId','$bookingId','" . $post['subRoute'] . "','" . $post['discount'] . "','" . $post['seat'] . "', '$computedFare')");

            if ($insertBooking->execute() && $insertBookingDetails->execute()) {
                return 200;
            } else {
                return 404;
            }
        }
    }*/

    public function walkInBooking($post)
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

        $fare = $subRoute['fare'];

        $computedDiscount = $fare * $discountPercentage;
        $computedFare = $fare - $computedDiscount;

        $bookingIdValue = $bookingId;
        $routeAvIdValue = $post['routeAvId'];
        $bookByValue = $post['bookBy'];
        $bookingDateValue = $bookingDate->format('Y-m-d H:i:s');
        $expirationDateValue = $expirationDate->format('Y-m-d H:i:s');


        $insertBooking = $this->conn->prepare("INSERT INTO `booking`(`booking_id`, `route_av_id`, `acc_id`, `booking_date`, `booking_expiration`, `booking_type`, `status`) 
                                       VALUES (?, ?, ?, ?, ?, 'walk in', 'pending')");

        $insertBooking->bind_param("sssss", $bookingIdValue, $routeAvIdValue, $bookByValue, $bookingDateValue, $expirationDateValue);
        $insertBooking->execute();

        $insertBookingDetails = $this->conn->prepare("INSERT INTO `booking_details`(`bd_id`, `booking_id`, `sr_id`, `discount_id`, `seat_no`, `computed_fare`) 
                                              VALUES (?, ?, ?, ?, ?, ?)");

        $insertBookingDetails->bind_param("sssssi", $bookingDetailsId, $bookingId, $post['subRoute'], $post['discount'], $post['seat'], $computedFare);
        $insertBookingDetails->execute();

        if ($insertBooking->affected_rows > 0 && $insertBookingDetails->affected_rows > 0) {
            return $bookingId;
        } else {
            return 404;
        }
    }

    public function walkInAddBooking($post)
    {
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

        $insertBooking = $this->conn->prepare("INSERT INTO `booking_details`(`bd_id`, `booking_id`, `sr_id`, `discount_id`, `seat_no`, `computed_fare`) 
                                                        VALUES ('$bookingDetailsId','" . $post['bookingId'] . "','" . $post['subRoute'] . "','" . $post['discount'] . "','" . $post['seat'] . "', '$computedFare')");
        if ($insertBooking->execute()) {
            return 200;
        }
    }

    public function getAllBookings()
    {
        $query = $this->conn->prepare("SELECT b.*, a.name FROM `booking` AS b LEFT JOIN `accounts` AS a ON b.acc_id = a.acc_id");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getBookingAmount($bookingId)
    {
        $query = $this->conn->prepare("SELECT SUM(computed_fare) AS total_amount FROM booking_details WHERE `booking_id` = '$bookingId'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getBookingInformation($bookingId)
    {
        $query = $this->conn->prepare("SELECT b.*, b.status AS booking_status,ra.*, r.origin, r.destination, r.route_id,a.name FROM `booking` AS b 
                                       LEFT JOIN `routes_available` AS ra ON b.route_av_id = ra.route_av_id
                                       LEFT JOIN `routes` AS r ON ra.route_id = r.route_id
                                       LEFT JOIN `accounts` AS a ON b.acc_id = a.acc_id
                                       WHERE b.booking_id = '$bookingId'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getBookingDetails($bookingId)
    {
        $query = $this->conn->prepare("SELECT bd.*, sr.origin, sr.destination, d.discount_type FROM `booking_details` AS bd 
                                       JOIN `sub_routes` AS sr ON bd.sr_id = sr.sr_id
                                       LEFT JOIN `discounts` d ON bd.discount_id = d.discount_id
                                       WHERE bd.booking_id = '$bookingId'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function markAsPaid($bookingId)
    {
        $query = $this->conn->prepare("UPDATE `booking` SET `status`='Paid' WHERE `booking_id` = '$bookingId'");
        if ($query->execute()) {
            return 200;
        }
    }

    public function cancelBooking($bookingId)
    {
        $query = $this->conn->prepare("UPDATE `booking` SET `status`='Cancelled' WHERE `booking_id` = '$bookingId'");
        if ($query->execute()) {
            return 200;
        }
    }

    public function checkBookingIfExpired()
    {
        $query = $this->conn->prepare("SELECT * FROM `booking` WHERE `status` != 'Expired' AND `status` != 'Paid'");
        $query->execute();
        $notExpiredResult = $query->get_result();
        while ($notExpiredRow = $notExpiredResult->fetch_assoc()) {
            $bookingId = $notExpiredRow['booking_id'];
            $today = new DateTime();
            $expirationDate = new DateTime($notExpiredRow['booking_expiration']);
            if ($expirationDate < $today) {
                $updateStatusToExpired = $this->conn->prepare("UPDATE `booking` SET `status`='Expired' WHERE `booking_id` = '$bookingId'");
                $updateStatusToExpired->execute();
            }
        }
    }

    public function deleteBooking($bdId)
    {
        $query = $this->conn->prepare("DELETE FROM `booking_details` WHERE `bd_id` = '$bdId'");
        if ($query->execute()) {
            return 200;
        }
    }

    public function editBooking($post)
    {
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

        $query = $this->conn->prepare("UPDATE `booking_details` SET `sr_id`='" . $post['subRoute'] . "',`discount_id`='" . $post['discount'] . "',`seat_no`='" . $post['seat'] . "',`computed_fare`='" . $computedFare . "' WHERE `bd_id` = '" . $post['bdId'] . "'");
        if ($query->execute()) {
            return 200;
        }
    }
}
