<?php

require_once(LIB_PATH . DS . 'initialize.php');

class Expert extends DatabaseObject {

    protected static $table_name = "experts";
    protected static $db_fields = array("id", "name", "institution", "lat", "lon");
    public $id;
    public $name;
    public $institution;
    public $lat;
    public $lon;
    
    public static function find_all() {
        return static::find_by_sql("SELECT * FROM experts ORDER BY name ASC");
    }

    public static function write_to_file() {
        $file = SITE_ROOT . DS . 'js' . DS . 'experts.csv';
        file_put_contents($file, "name,institution,lat,lon" . PHP_EOL);

        $experts = Expert::find_all();
        foreach ($experts as $expert) {
            file_put_contents($file, "\"{$expert->name}\",\"{$expert->institution}\",{$expert->lat},{$expert->lon}" . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
    }

}
