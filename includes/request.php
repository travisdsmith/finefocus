<?php

require_once(LIB_PATH . DS . 'initialize.php');

class Request extends DatabaseObject {

    protected static $table_name = "requests";
    protected static $db_fields = array("id", "request_date", "request_type", "name", "address_1", "address_2", "city", "state", "postal_code", "country", "email", "requested_journal", "additional_comments", "fulfillment_status", "fulfillment_date", "referer", "notes");
    public $id;
    public $request_date;
    public $request_type;
    public $name;
    public $address_1;
    public $address_2;
    public $city;
    public $state;
    public $postal_code;
    public $country;
    public $email;
    public $requested_journal;
    public $additional_comments;
    public $fulfillment_status;
    public $fulfillment_date;
    public $referer;
    public $notes;
    
    public static function first_request_date() {
        global $database;
        $sql = "SELECT MIN(request_date) FROM  " . Request::get_table_name();
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    public static function count_by_fulfillment_status($status) {
        global $database;
        $sql = "SELECT COUNT(*) FROM " . Request::get_table_name() . " WHERE fulfillment_status={$status}";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    public static function count_by_request_type($type) {
        global $database;
        $sql = "SELECT COUNT(*) FROM " . Request::get_table_name() . " WHERE request_type='{$type}'";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    public static function average_turnaround(){
        global $database;
        $sql = "SELECT ROUND(AVG(DATEDIFF(fulfillment_date, request_date))) FROM " . Request::get_table_name() . " WHERE fulfillment_date IS NOT NULL";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    public static function count_by_country(){
        global $database;
        $sql = "SELECT country, COUNT(*) AS cnt FROM " . Request::get_table_name() . " ORDER BY cnt DESC";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    public static function count_records_by_month($measure, $month, $year){
        global $database;
        if($measure=="r"){
            $sql = "SELECT COUNT(*) FROM " . Request::get_table_name() . " WHERE MONTH(request_date)={$month} AND YEAR(request_date)={$year};";
        } else if ($measure=="f"){
            $sql = "SELECT COUNT(*) FROM " . Request::get_table_name() . " WHERE MONTH(fulfillment_date)={$month} AND YEAR(fulfillment_date)={$year};";
        }
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    public static function count_records_in_past_days($days){
        global $database;
        $sql = "SELECT COUNT(*) FROM " . Request::get_table_name() . " WHERE DATEDIFF(NOW(), request_date)<={$days};";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    public function get_status() {
        $status = "";
        switch ($this->fulfillment_status) {
            case -1:
                $status = "Rejected";
                break;
            case 0:
                $status = "Unfulfilled";
                break;
            case 1:
                $status = "Fulfilled";
                break;
            default:
                $status = "Unknown";
                break;
        }
        return $status;
    }
    
    public function get_type() {
        $type = "";
        switch ($this->request_type) {
            case "p":
                $type = "Personal";
                break;
            case "o":
                $type = "Organizational";
                break;
            default:
                $type = "Unknown";
                break;
        }
        return $type;
    }
}
