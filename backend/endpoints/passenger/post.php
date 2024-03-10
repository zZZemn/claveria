<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include('../../database/class.php');
$db = new global_class();

if (isset($_POST['submitType'])) {
    $submitType = $_POST['submitType'];
    if ($submitType == 'EditProfile') {
        echo $db->editProfile($_SESSION['id'], $_POST);
    } elseif ($submitType == 'Book') {
        echo $db->book($_SESSION['id'], $_POST);
    }
} else {
    echo 'hoy';
}
