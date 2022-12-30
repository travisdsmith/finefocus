<?php
require_once('includes/initialize.php');

require_once(LAYOUT_PATH . DS . 'header.php');

$experts = Expert::find_all();
echo "<div class=\"content_text\">" . PHP_EOL;
echo "<h1>All Experts</h1>" . PHP_EOL;
echo "<p>" . PHP_EOL;
foreach ($experts as $expert){
    echo "<b>{$expert->name}</b>: {$expert->institution}<br/>" . PHP_EOL;
}
echo "</div>" . PHP_EOL;

require_once(LAYOUT_PATH . DS . 'footer.php');