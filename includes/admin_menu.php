<?php

require_once(LIB_PATH . DS . 'initialize.php');

class Admin_Menu extends DatabaseObject {
    protected static $table_name = "admin_menu";
    protected static $db_fields = array("id", "group", "order", "icon", "title", "href", "permissions");
    public $id;
    public $group;
    public $order;
    public $icon;
    public $title;
    public $href;
    public $permissions;
    
    public static function find_max_group(){
        global $database;
        $sql = "SELECT MAX(`group`) FROM admin_menu;";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    public static function find_group_permissions($group){
        global $database;
        $sql = "SELECT AVG(`permissions`) FROM admin_menu WHERE `group`={$group};";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    public static function find_by_group($input) {
        return Admin_Menu::find_by_sql("SELECT * FROM admin_menu WHERE `group`={$input} ORDER BY `order` ASC;");
    }
}