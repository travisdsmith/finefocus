<?php
$admin_page = 0;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if(filter_input(INPUT_GET, "action")=="add"){
    $quick_access = new Quick_Access();
    $quick_access->user = $session->user_id->id;
    $quick_access->title = filter_input(INPUT_GET, "title");
    $quick_access->href = filter_input(INPUT_GET, "href");
    if($quick_access->create()){
        $session->message("success|Link added to the quick access menu.");
    } else {
        $session->message("danger|Link could not be added to the quick access menu.");
    }
    redirect_to(filter_input(INPUT_GET, "href"));
} else if (filter_input(INPUT_GET, "action")=="remove"){
    $quick_access = Quick_Access::find_by_user_and_href($session->user_id->id, filter_input(INPUT_GET, "href"));
    if($quick_access->delete()){
        $session->message("success|Link removed from the quick access menu.");
    } else {
        $session->message("danger|Link could not be removed from the quick access menu.");
    }
    redirect_to(filter_input(INPUT_GET, "href"));
} else {
    redirect_to("index.php");
}