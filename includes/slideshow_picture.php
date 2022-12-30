<?php

require_once(LIB_PATH . DS . 'initialize.php');

class Slideshow_Picture extends DatabaseObject {

    protected static $table_name = "slideshow_pictures";
    protected static $db_fields = array("id", "slideshow", "caption", "filename");
    public $id;
    public $slideshow;
    public $caption;
    public $filename;

    public static function find_by_slideshow_id($id) {
        return Slideshow_Picture::find_by_sql("SELECT * FROM slideshow_pictures WHERE slideshow='{$id}'");
    }
    
    public static function count_by_slideshow_id($id) {
        global $database;
        $sql = "SELECT COUNT(*) FROM " . static::$table_name . " WHERE slideshow='{$id}'";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

}
