<?php
include('../../database/class.php');
$db = new global_class();

if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $getUser = $db->getUserUsingUsername($username);

    if ($getUser->num_rows > 0) {
        $user = $getUser->fetch_assoc();
        if ($user['password'] == $password) {
            session_start();
            $_SESSION['id'] = $user['acc_id'];
            $_SESSION['acc_type'] = $user['acc_type'];
            echo 200;
        } else {
            echo 400;
        }
    } else {
        echo 400;
    }
}
