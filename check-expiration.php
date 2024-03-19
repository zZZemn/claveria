<?php 
include ("backend/database/class.php");
$db = new global_class();
$db->checkBookingIfExpired();
?>