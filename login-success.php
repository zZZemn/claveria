<?php
session_start();
if (isset($_SESSION['id'], $_SESSION['acc_type'])) {
    $accType = $_SESSION['acc_type'];
    if ($accType == 'admin') {
        header('Location: frontend/management/management.php');
        exit();
    } elseif ($accType == 'passenger') {
        header('Location: frontent/passenger/passenger.php');
        exit();
    } elseif ($accType == 'inspector') {
        header('Location: frontent/inspector/inspector.php');
        exit();
    } else {
        // header('Location: index.php');
        // exit();
        echo 'asd';
    }
} else {
    // header('Location: index.php');
    // exit();
    echo 'asd2';
}
