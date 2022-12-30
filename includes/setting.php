<?php

require_once(LIB_PATH . DS . 'initialize.php');

class Setting extends DatabaseObject{
    protected static $table_name = "settings";
    protected static $db_fields = array("id",  "value");
    public $id;
    public $value;
}