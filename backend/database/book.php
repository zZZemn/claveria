<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require('../../PHPMailer/src/PHPMailer.php');
require('../../PHPMailer/src/SMTP.php');
require('../../PHPMailer/src/Exception.php');

include('conn.php');

$accId = $_SESSION['id'];
$post = $_POST;

$bookingDate = new DateTime();
$expirationDate = clone $bookingDate;
$expirationDate->add(new DateInterval('PT24H'));;


function generateId($firstCharacters, $lengthOfNumber)
{
    $randomNumber = mt_rand(pow(10, $lengthOfNumber - 1), pow(10, $lengthOfNumber) - 1);
    $generatedId = $firstCharacters . '-' . $randomNumber;

    return $generatedId;
}

function checkGeneratedId($table, $column, $id)
{
    global $conn;
    $sql = "SELECT * FROM `$table` WHERE `$column` = '$id'";
    if ($conn->query($sql)) {
        return $conn->query($sql);
    }
}

function checkPendingBooking($accId)
{
    global $conn;
    $sql = "SELECT * FROM `booking` WHERE `acc_id` = '$accId' AND `status` = 'pending'";
    if ($conn->query($sql)) {
        return $conn->query($sql);
    }
}

// Generate ID
$bookingId = generateId("BOOKING", 8);
while (checkGeneratedId("booking", "booking_id", $bookingId)->num_rows > 0) {
    $bookingId = generateId("BOOKING", 8);
}


$bookingDetailsId = generateId("BD", 10);
while (checkGeneratedId("booking_details", "bd_id", $bookingDetailsId)->num_rows > 0) {
    $bookingDetailsId = generateId("BD", 10);
}
// End of Generate ID

$getSubroute = checkGeneratedId("sub_routes", "sr_id", $post['subRoute']);
$subRoute = $getSubroute->fetch_assoc();

$getDiscount = checkGeneratedId("discounts", "discount_id", $post['discount']);
if ($getDiscount->num_rows > 0) {
    $discount = $getDiscount->fetch_assoc();
    $discountPercentage = $discount['discount_percentage'];
} else {
    $discountPercentage = 0;
}

// User Details
$getUser = checkGeneratedId("accounts", "acc_id", $accId);
$userDetails = $getUser->fetch_assoc();
$userEmail = $userDetails['email'];
$userName = $userDetails['name'];
// End of User Details

// Computation;
$fare = $subRoute['fare'];

$computedDiscount = $fare * $discountPercentage;
$computedFare = $fare - $computedDiscount;
// End of Computation

$checkPendingBooking = checkPendingBooking($accId);
if ($checkPendingBooking->num_rows > 0) {
    $pendingBooking = $checkPendingBooking->fetch_assoc();
    $pendingBookingId = $pendingBooking['booking_id'];
    if ($pendingBooking['route_av_id'] == $post['routeAvId']) {
        $insertBooking = "INSERT INTO `booking_details`(`bd_id`, `booking_id`, `sr_id`, `discount_id`, `seat_no`, `computed_fare`) 
                                                        VALUES ('$bookingDetailsId','$pendingBookingId','" . $post['subRoute'] . "','" . $post['discount'] . "','" . $post['seat'] . "', '$computedFare')";
        if ($conn->query($insertBooking)) {
            echo 201;
        }
    } else {
        echo 404;
    }
} else {
    // Email sending
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ugabane0516@gmail.com';
    $mail->Password = 'owwj dmzb hypq lsfu';
    $mail->SMTPSecure = 'ssl'; // or 'ssl' if applicable
    $mail->Port = 465; // or the appropriate SMTP port provided by Hostinger

    $mail->setFrom('ugabane0516@gmail.com', 'CLAVERIA BUS TRANSPORT INCORPORATION MANAGEMENT SYSTEM');
    $mail->addAddress($userEmail);
    $mail->isHTML(true);
    $mail->Subject = 'Booking of Bus';
    $mail->Body = '
                            <html>
                            <head>
                                <style>
                                    body {
                                        font-family: Arial, sans-serif;
                                        background-color: #f1f1f1;
                                        padding: 20px;
                                    }
                                    .container {
                                        background-color: #fff;
                                        border-radius: 5px;
                                        padding: 20px;
                                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                                    }
                                    h1 {
                                        color: #333;
                                    }
                                    p {
                                        color: #777;
                                        margin-bottom: 10px;
                                    }
                                    .verification-code {
                                        font-size: 24px;
                                        font-weight: bold;
                                        color: #007bff;
                                    }
                                </style>
                            </head>
                            <body>
                                <div class="container">
                                    <h1>Booking Success!</h1>
                                    <p>Hi ' . $userName . ',</p>
                                    <p>Thank you for booking, Your booking ID is:</p>
                                    <p class="verification-code">' . $bookingId . '</p>
                                </div>
                            </body>
                            </html>';

    // End of email sending

    $insertBooking = "INSERT INTO `booking`(`booking_id`, `route_av_id`, `acc_id`, `booking_date`, `booking_expiration`, `booking_type`, `status`) 
                                                                    VALUES ('$bookingId','" . $post['routeAvId'] . "','$accId','" . $bookingDate->format('Y-m-d H:i:s') . "','" . $expirationDate->format('Y-m-d H:i:s') . "','online','pending')";

    $insertBookingDetails = "INSERT INTO `booking_details`(`bd_id`, `booking_id`, `sr_id`, `discount_id`, `seat_no`, `computed_fare`) 
                                                                                VALUES ('$bookingDetailsId','$bookingId','" . $post['subRoute'] . "','" . $post['discount'] . "','" . $post['seat'] . "', '$computedFare')";

    if ($conn->query($insertBooking) && $conn->query($insertBookingDetails)) {
        $mail->send();
        echo 200;
    } else {
        echo 404;
    }
}
