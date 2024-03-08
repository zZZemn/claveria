<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../../database/class.php');
$db = new global_class();

if (isset($_POST['username'], $_FILES['validId'])) {
    echo $signIn = $db->signIn($_POST, $_FILES['validId']);
}
