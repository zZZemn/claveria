<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include('../../database/class.php');
$db = new global_class();

if (isset($_POST['submitType'])) {
    $submitType = $_POST['submitType'];
    if ($submitType == 'AddRouteSched') {
        echo $db->addRouteSched($_POST);
    } elseif ($submitType == 'AddRoute') {
        echo $db->addRoute($_POST);
    } elseif ($submitType == 'AddSubRoute') {
        echo $db->addSubRoute($_POST);
    } elseif ($submitType == 'AddBus') {
        echo $db->addBus($_POST['plateNumber']);
    } elseif ($submitType == 'AddAnnouncement') {
        echo $db->addAnnouncement($_POST);
    } elseif ($submitType == 'MarkAsPaid') {
        echo $db->markAsPaid($_POST['bookingId']);
    } elseif ($submitType == 'Book') {
        echo $db->walkInBooking($_POST);
    } elseif ($submitType == 'AddBook') {
        echo $db->walkInAddBooking($_POST);
    } elseif ($submitType == 'AddInspector') {
        echo $db->addInspector($_POST);
    }
} else {
    echo 'hoy';
}
