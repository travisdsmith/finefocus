<?php

//VALIDATION FUNCTIONS
$errors = array();

function fieldname_as_text($fieldname) {
    $fieldname = str_replace("_", " ", $fieldname);
    $fieldname = ucfirst($fieldname);
    return $fieldname;
}

function has_presence($value) {
    return isset($value) && $value !== "";
}

function validate_presences($required_fields) {
    global $errors;
    foreach ($required_fields as $field) {
        $value = trim(filter_input(INPUT_POST, $field));
        if (!has_presence($value)) {
            $errors[$field] = fieldname_as_text($field) . " can't be blank.";
        }
    }
}

//OTHER FUNCTIONS
function redirect_to($location = NULL) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

spl_autoload_register('autoloader');

function autoloader($class_name) {
    $class_name = strtolower($class_name);
    $path = LIB_PATH . DS . "{$class_name}.php";
    if (file_exists($path)) {
        require_once($path);
    } else {
        die("The file {$class_name}.php could not be found.");
    }
}

function output_message($message) {
    $msg_arr = explode("|", $message);
    if (!empty($msg_arr[1])) {
        switch ($msg_arr[0]) {
            case "info":
                return "<div class=\"alert alert-info\" role=\"alert\"><i class=\"fa fa-info-circle\"></i> " . htmlentities($msg_arr[1]) . "</div>";
            case "success":
                return "<div class=\"alert alert-success\" role=\"alert\"><i class=\"fa fa-check-circle\"></i> " . htmlentities($msg_arr[1]) . "</div>";
            case "warning":
                return "<div class=\"alert alert-warning\" role=\"alert\"><i class=\"fa fa-exclamation-circle\"></i> " . htmlentities($msg_arr[1]) . "</div>";
            case "danger":
                return "<div class=\"alert alert-danger\" role=\"alert\"><i class=\"fa fa-times-circle\"></i> " . htmlentities($msg_arr[1]) . "</div>";
        }
    } else {
        return "";
    }
}

function slugify($text) {
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function color_scheme($number){
    $scheme_array= ["51,123,183", "43,190,131", "126,177,220", "121,223,182", "83,147,200", "76,205,153", "18,101,171", "8,179,110", "9,75,131", "0,138,82", "68,66,194", "255,172,58", "139,137,225", "255,206,138", "99,97,208", "255,187,95", "37,34,183", "255,152,11", "22,20,141", "202,117,0"];
    return $scheme_array[$number%20];
}

function get_between($content, $start, $end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}

//SHORTCODE FUNCTIONS

function expand_shortcodes($shortcode){
    $shortcode_array = explode(" ", $shortcode);
    switch($shortcode_array[0]){
        case "slideshow":
            $slideshow = Slideshow::find_by_slug($shortcode_array[1]);
            if($slideshow){
                return $slideshow->write();
            } else {
                return "";
            }
        default:
            return "";
    }
    
}