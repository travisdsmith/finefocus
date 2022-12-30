<?php

require_once(LIB_PATH . DS . 'initialize.php');

class Slideshow extends DatabaseObject {

    protected static $table_name = "slideshows";
    protected static $db_fields = array("id", "slug", "description", "slide", "indicators", "controls", "interval", "pause", "wrap");
    public $id;
    public $slug;
    public $description;
    public $slide;
    public $indicators;
    public $controls;
    public $interval;
    public $pause;
    public $wrap;

    public static function find_by_slug($slug) {
        $result_array = static::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE slug='{$slug}' LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public function destroy(){
        $slideshow_pictures = Slideshow_Picture::find_by_slideshow_id($this->id);
        foreach($slideshow_pictures as $slideshow_picture){
            $slideshow_picture->delete();
        }
        $this->delete();
    }

    public function write() {
        $slideshow_pictures = Slideshow_Picture::find_by_slideshow_id($this->id);

        $result = "<div id=\"{$this->slug}\" class=\"carousel" . ($this->slide > 0 ? " slide" : "") . "\" data-ride=\"carousel\" data-interval=\"{$this->interval}\" data-pause=\"" . ($this->pause == 1 ? "hover" : "false") . "\" data-wrap=\"" . ($this->wrap == 1 ? "true" : "false") . "\">" . PHP_EOL;

        if ($this->indicators > 0) {
            $result .= "<ol class=\"carousel-indicators\">" . PHP_EOL;
            for ($i = 0; $i < count($this_pictures); $i++) {
                $result .= "<li data-target=\"#{$this->slug}\" data-slide-to=\"{$i}\"" . ($i == 0 ? " class=\"active\">" : "") . "</li>" . PHP_EOL;
            }
            $result .= "</ol>" . PHP_EOL;
        }

        $result .= "<div class=\"carousel-inner\" role=\"listbox\">" . PHP_EOL;
        $iterator = 0;
        foreach ($slideshow_pictures as $slideshow_picture) {
            $result .= "<div class=\"item" . ($iterator == 0 ? " active" : "") . "\">" . PHP_EOL;
            $result .= "<img src=\"{$slideshow_picture->filename}\">" . PHP_EOL;
            if ($slideshow_picture->caption != "") {
                $result .= " <div class=\"carousel-caption\">" . $slideshow_picture->caption . "</div>" . PHP_EOL;
            }
            $result .= "</div>" . PHP_EOL;
            $iterator++;
        }
        $result .= "</div>" . PHP_EOL;

        if ($this->controls > 0) {
            $result .= "<a class=\"left carousel-control\" href=\"#{$this->slug}\" role=\"button\" data-slide=\"prev\"><span class=\"glyphicon glyphicon-chevron-left\" aria-hidden=\"true\"></span><span class=\"sr-only\">Previous</span></a><a class=\"right carousel-control\" href=\"#{$this->slug}\" role=\"button\" data-slide=\"next\"><span class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span><span class=\"sr-only\">Next</span></a>" . PHP_EOL;
        }

        $result .= "</div>" . PHP_EOL;
        return $result;
    }

}
