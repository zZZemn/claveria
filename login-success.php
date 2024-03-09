<?php
session_start();
if (isset($_SESSION['id'], $_SESSION['acc_type'])) {
    $accType = $_SESSION['acc_type'];
    if ($accType == 'admin') {
        header('Location: frontend/management/booking.php');
        exit();
    } elseif ($accType == 'passenger') {
        header('Location: frontend/passenger');
        exit();
    } elseif ($accType == 'inspector') {
        header('Location: frontend/inspector/inspector.php');
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
