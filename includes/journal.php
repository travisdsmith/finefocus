<?php

require_once(LIB_PATH . DS . 'initialize.php');

class Journal extends DatabaseObject {

    protected static $table_name = "journals";
    protected static $db_fields = array("id", "name", "release_date");
    public $id;
    public $name;
    public $release_date;

}
