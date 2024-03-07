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
    }
} else {
    echo 'hoy';
}
