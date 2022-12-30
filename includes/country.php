<?php
//http://data.okfn.org/data/core/country-list
require_once(LIB_PATH . DS . 'initialize.php');

class Country extends DatabaseObject {

    protected static $table_name = "countries";
    protected static $db_fields = array("id", "name");
    public $id;
    public $name;
    
    public static function find_all() {
        return static::find_by_sql("SELECT * FROM countries ORDER BY name ASC");
    }
}