<?php
$admin_page = 8;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_GET, "id")) {
    $slideshow_picture = Slideshow_Picture::find_by_id(filter_input(INPUT_GET, "id"));

    if ($slideshow_picture) {
        if (filter_input(INPUT_POST, "confirm")) {
            if ($slideshow_picture->delete()) {
                $session->message("success|The slide was deleted.");
            } else {
                $session->message("danger|Slide deletion failed.");
            }
            redirect_to("slideshow_edit.php?id=" . $slideshow_picture->slideshow);
        } else {
            require_once(LAYOUT_PATH . DS . "admin_header.php")
            ?>
            <h1 class="page-header"><i class="fa fa-picture-o fa-fw"></i>&nbsp;Delete Slide</h1>
            <div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-circle"></i> Please confirm deletion of this slide.</div>
            <form class="form-horizontal" role="form" action="slideshowpicture_delete.php?id=<?= $slideshow_picture->id ?>" method="POST">
                <div class="form-group">
                    <label for="file_upload" class="col-sm-2 control-label">Preview</label>
                    <div class="col-sm-10">
                        <a href="<?=$slideshow_picture->filename?>" target="_blank"><img src="<?=$slideshow_picture->filename?>" class="img-responsive" width="500px;" alt="Preview not available."/></a>
                        <p class="help-block">Click on the photo to view the original version.</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Caption</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $slideshow_picture->caption ?></p>
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