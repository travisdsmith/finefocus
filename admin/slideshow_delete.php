<?php
$admin_page = 5;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_GET, "id")) {
    $slideshow = Slideshow::find_by_id(filter_input(INPUT_GET, "id"));

    if ($slideshow) {
        if (filter_input(INPUT_POST, "confirm")) {
            if ($slideshow->delete()) {
                $session->message("success|The slideshow was deleted.");
            } else {
                $session->message("danger|Slideshow deletion failed.");
            }
            redirect_to("slideshow_all.php");
        } else {
            require_once(LAYOUT_PATH . DS . "admin_header.php")
            ?>
            <h1 class="page-header"><i class="fa fa-play-circle-o fa-fw"></i>&nbsp;Delete Slideshow</h1>
            <div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-circle"></i> Please confirm deletion of this slideshow.</div>
            <form class="form-horizontal" role="form" action="slideshow_delete.php?id=<?= $slideshow->id ?>" method="POST">
                <div class="form-group">
                    <label for="slideshow_name" class="col-sm-2 control-label">Slug</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $slideshow->slug ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="datepicker" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $slideshow->description ?></p>
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
        redirect_to("slideshow_all.php");
    }
} else {
    redirect_to("slideshow_all.php");
}