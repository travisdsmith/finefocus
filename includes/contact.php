<?php

require_once(LIB_PATH . DS . 'initialize.php');

class Contact extends DatabaseObject {

    protected static $table_name = "contacts";
    protected static $db_fields = array("id", "name", "address1", "address2", "city", "state", "postal_code", "country", "email", "date_added", "notes");
    public $id;
    public $name;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $postal_code;
    public $country;
    public $email;
    public $date_added;
    public $notes;
    
    public function readable_date_added(){
        $date = new DateTime($this->date_added);
        return date_format($date, 'F d, Y');
    }

}
