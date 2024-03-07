<?php
include('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    // accounts
    public function getUserUsingUsername($username)
    {
        $query = $this->conn->prepare("SELECT * FROM `accounts` WHERE `username` = '$username'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getUserUsingId($id)
    {
        $query = $this->conn->prepare("SELECT * FROM `accounts` WHERE `acc_id` = '$id'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
}
