<?php

require_once(LIB_PATH . DS . 'initialize.php');

class Page extends DatabaseObject {

    protected static $table_name = "pages";
    protected static $db_fields = array("id", "title", "slug", "content_indented", "content_unindented");
    public $id;
    public $title;
    public $slug;
    public $content_indented;
    public $content_unindented;

    public static function find_by_slug($slug = "index") {
        $result_array = static::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE slug='{$slug}' LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public function preview() {
        return substr(strip_tags($this->content_indented . $this->content_unindented), 0, 60) . "...";
    }

    public function render() {
        require_once('layouts/header.php');

        echo '<div class="row"><div class="col-sm-12 col-md-3"></div><div class="col-sm-12 col-md-9">' . PHP_EOL;
        echo ($this->id!=Setting::find_by_id('homepage')->value ? "<h1>{$this->title}</h1>" : "") . PHP_EOL;
        
        $content_indented = $this->content_indented;
        while ($shortcode = get_between($content_indented, "[[", "]]")) {
            $content_indented = str_replace("[[" . $shortcode . "]]", expand_shortcodes($shortcode), $content_indented);
        }
        echo $content_indented;
        echo '</div></div>' . PHP_EOL;

        $content_unindented = $this->content_unindented;
        while ($shortcode = get_between($content_unindented, "[[", "]]")) {
            $content_unindented = str_replace("[[" . $shortcode . "]]", expand_shortcodes($shortcode), $content_unindented);
        }
        echo $content_unindented;

        require_once('layouts/footer.php');
    }

}
