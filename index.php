<?php

require_once('includes/initialize.php');

if (filter_input(INPUT_GET, 'id')) {
    if (filter_input(INPUT_GET, 'id') == 'admin') {
        redirect_to('admin/index.php');
    }

    $page = Page::find_by_slug(filter_input(INPUT_GET, 'id'));
    if ($page) {
        $page->render();
    } else {
        redirect_to("404.shtml");
    }
} else {
    Page::find_by_id(Setting::find_by_id('homepage')->value)->render();
}