<?php
session_start();
include('../../backend/database/class.php');
if (isset($_SESSION['id'], $_SESSION['acc_type'])) {
    $db = new global_class();
    $id = $_SESSION['id'];
    $getAccount = $db->getUserUsingId($id);
    if ($getAccount->num_rows > 0) {
        $account = $getAccount->fetch_assoc();
    } else {
        header('Location: ../../index.php');
        exit();
    }
} else {
    header('Location: ../../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claveria Bus Inc.</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <nav class="d-flex justify-content-between align-items-center p-3">
        <a href="management.php"><img class="logo" src="../../assets/CBTIMS LOGO.png" alt="Logo"></a>
        <a href="../../logout.php" class="btn-logout text-light text-decoration-none"><i class="bi bi-box-arrow-left"></i> Log Out</a>
    </nav>
    <aside class="side-bar">
        <ul>
            <li><a href="#" id="nav-booking"><i class="bi bi-pen"></i> Booking</a></li>
            <li><a href="#" id="nav-routes"><i class="bi bi-geo-alt"></i> Routes</a></li>
            <li><a href="#" id="nav-announcement"><i class="bi bi-megaphone"></i> Announcements</a></li>
            <li><a href="#" id="nav-sales-report"><i class="bi bi-receipt"></i> Sales Report</a></li>
        </ul>
    </aside>