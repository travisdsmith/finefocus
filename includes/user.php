<?php

class User extends DatabaseObject {

    protected static $table_name = "users";
    protected static $db_fields = array('id', 'username', 'password', 'permissions', 'last_login');
    public $id;
    public $username;
    public $password;
    public $permissions;
    public $last_login;

    public static function find_by_username($username = "") {
        $result_array = static::find_by_sql("SELECT * FROM users WHERE username='{$username}' LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function authenticate($username = "", $password = "") {
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);

        $user = self::find_by_username($username);
        $hashed_password = "";
        if (!empty($user)) {
            $hashed_password = crypt($password, $user->password);
        }

        $sql = "SELECT * FROM users ";
        $sql .= "WHERE username = '{$username}' ";
        $sql .= "AND password = '{$hashed_password}' ";
        $sql .= "LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public function get_type() {
        $type = "";
        switch ($this->permissions) {
            case 0:
                $type = "Request Fulfillment";
                break;
            case 1:
                $type = "Standard User";
                break;
            case 2:
                $type = "Administrator";
                break;
            case 3:
                $type = "Primary Administrator";
                break;
            default:
                $type = "Unknown";
                break;
        }
        return $type;
    }

    public function delete() {
        global $database;
        $quick_access_items = Quick_Access::find_by_user($this->id);
        foreach ($quick_access_items as $quick_access_item) {
            $quick_access_item->delete();
        }
        $query = "DELETE FROM " . static::$table_name;
        $query .= " WHERE id='" . $database->escape_value($this->id);
        $query .= "' LIMIT 1";
        $database->query($query);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public static function count_primary_administrators() {
        global $database;
        $sql = "SELECT COUNT(*) FROM " . User::get_table_name() . " WHERE permissions=" . PRIMARY_ADMINISTRATOR;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

}
