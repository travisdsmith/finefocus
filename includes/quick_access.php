<?php

require_once(LIB_PATH . DS . 'initialize.php');

class Quick_Access extends DatabaseObject {
    protected static $table_name = "quick_access";
    protected static $db_fields = array("id", "user", "href", "title");
    public $id;
    public $user;    
    public $href;
    public $title;
    
    public static function find_by_user($input) {
        return Quick_Access::find_by_sql("SELECT * FROM quick_access WHERE `user`={$input};");
    }
    
    public static function find_by_user_and_href($user, $href) {
        $result_array = static::find_by_sql("SELECT * FROM quick_access WHERE user='{$user}' AND href='{$href}' LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
}