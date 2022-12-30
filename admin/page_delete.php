<?php
$admin_page = 4;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_GET, "id")) {
    $page = Page::find_by_id(filter_input(INPUT_GET, "id"));

    if ($page) {
        if (filter_input(INPUT_POST, "confirm")) {
            if ($page->delete()) {
                $session->message("success|The page was deleted.");
            } else {
                $session->message("danger|Page deletion failed.");
            }
            redirect_to("page_all.php");
        } else {
            require_once(LAYOUT_PATH . DS . "admin_header.php")
            ?>
            <h1 class="page-header"><i class="fa fa-book fa-fw"></i>&nbsp;Delete Page</h1>
            <div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-circle"></i> Please confirm deletion of this page.</div>
            <form class="form-horizontal" role="form" action="page_delete.php?id=<?= $page->id ?>" method="POST">
                <div class="form-group">
                    <label for="page_name" class="col-sm-2 control-label">Page Title</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $page->title ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input class="btn btn-lg btn-danger" type="submit" name="confirm" id="confirm" value="Delete" />
                    </div>
                </div>
            </form>

            <?php
            require_once(LAYOUT_PATH . DS . "admin_footer.php");
        }
    } else {
        redirect_to("page_all.php");
    }
} else {
    redirect_to("page_all.php");
}