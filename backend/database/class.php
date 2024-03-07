<?php
include('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    // Generate
    public function generateId($firstCharacters, $lengthOfNumber)
    {
        $randomNumber = mt_rand(pow(10, $lengthOfNumber - 1), pow(10, $lengthOfNumber) - 1);
        $generatedId = $firstCharacters . '-' . $randomNumber;

        return $generatedId;
    }

    public function checkGeneratedId($table, $column, $id)
    {
        $query = $this->conn->prepare("SELECT * FROM `$table` WHERE `$column` = '$id'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
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

    // routes
    public function getRoutes()
    {
        $query = $this->conn->prepare("SELECT ra.*, r.origin, r.destination, r.fare, b.plate_number 
                                       FROM `routes_available` AS ra
                                       LEFT JOIN `routes` AS r ON ra.route_id = r.route_id
                                       LEFT JOIN `bus` AS b ON ra.bus_id = b.bus_id");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getRouteList()
    {
        $query = $this->conn->prepare("SELECT * FROM `routes`");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function addRouteSched($post)
    {
        $id = $this->generateId('RA-ID', 10);
        while ($this->checkGeneratedId('routes_available', 'route_av_id', $id)->num_rows > 0) {
            $id = $this->generateId('RA-ID', 10);
        }

        $query = $this->conn->prepare("INSERT INTO `routes_available`(`route_av_id`, `route_id`, `bus_id`, `date_departure`, `date_arrival`, `added_passenger`,`status`) VALUES ('$id','" . $post['routeId'] . "','" . $post['busId'] . "','" . $post['departure'] . "','" . $post['arrival'] . "', 0,'Active')");
        if ($query->execute()) {
            echo 200;
        }
    }

    public function addRoute($post)
    {
        $id = $this->generateId('R-ID', 5);
        while ($this->checkGeneratedId('routes', 'route_id', $id)->num_rows > 0) {
            $id = $this->generateId('RA-ID', 5);
        }

        $query = $this->conn->prepare("INSERT INTO `routes`(`route_id`, `origin`, `destination`, `fare`) VALUES ('" . $id . "','" . $post['origin'] . "','" . $post['destination'] . "','" . $post['fare'] . "')");
        if ($query->execute()) {
            echo 200;
        }
    }

    // Bus
    public function getBus()
    {
        $query = $this->conn->prepare("SELECT * FROM `bus` WHERE `status` = '1'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
}
