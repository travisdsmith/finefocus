<?php

if (!$session->is_logged_in()) {
    redirect_to("login.php?redirect_to=" . basename(filter_input(INPUT_SERVER, "SCRIPT_FILENAME")));
}

if ($admin_page != 0) {
    if (Admin_Menu::find_by_id($admin_page)->permissions > User::find_by_id($session->user_id->id)->permissions) {
        redirect_to("access_denied.php");
    }
}