<?php
$admin_page = 8;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_POST, 'submit')) {
    if (Slideshow_Picture::find_by_id(filter_input(INPUT_GET, "id"))) {
        $slideshow_picture = Slideshow_Picture::find_by_id(filter_input(INPUT_GET, "id"));
    } else {
        $slideshow_picture = new Slideshow_Picture();
    }

    validate_presences(array('filename'));

    if (!empty($errors)) {
        $message = "danger|There were errors. " . join(" ", $errors);
    } else {
        $slideshow_picture->filename = filter_input(INPUT_POST, 'filename');
        $slideshow_picture->caption = filter_input(INPUT_POST, 'wysiwyg_slide');
        $slideshow_picture->slideshow = filter_input(INPUT_POST, 'slideshow');

        if ($slideshow_picture->save()) {
            $session->message("success|The slide was updated.");
            redirect_to('slideshow_edit.php?id=' . filter_input(INPUT_POST, 'slideshow'));
        } else {
            $message = "danger|The slide could not be updated.";
        }
    }
}
?>
<?php
require_once(LAYOUT_PATH . DS . "admin_header.php");
if (filter_input(INPUT_GET, "id")) {
    if ($slide = Slideshow_Picture::find_by_id(filter_input(INPUT_GET, "id"))) {
        ?>
        <h1 class="page-header"><i class="fa fa-play-circle-o fa-fw"></i>&nbsp;Edit Slide</h1>
        <?= output_message($message) ?>
        <form class="form-horizontal" role="form" action="slideshowpicture_edit.php?id=<?= $slide->id ?>" method="POST">
            <div class="form-group">
                <label for="filename" class="col-sm-2 control-label">Filename</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="filename" name="filename" placeholder="Filename" maxlength="1000" value="<?= filter_input(INPUT_POST, 'filename') ? filter_input(INPUT_POST, 'filename') : $slide->filename ?>" required>
                    <p class="help-block"><a href="media_all.php" target="_blank">Click here</a> to open the Media Library in a new tab.</p>
                </div>
            </div>
            <div class="form-group">
                <label for="wysiwyg_slide" class="col-sm-2 control-label">Caption</label>
                <div class="col-sm-10">
                    <textarea id="wysiwyg_slide" name="wysiwyg_slide"><?= filter_input(INPUT_POST, 'wysiwyg_slide') ? filter_input(INPUT_POST, 'wysiwyg_slide') : $slide->caption ?></textarea>
                </div>
            </div>
            <input type="hidden" id="slideshow" name="slideshow" value="<?=$slide->slideshow?>" />
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Update" />
                </div>
            </div>
        </form>
    <?php } else { ?>
        <h1 class="page-header"><i class="fa fa-play-circle-o fa-fw"></i>&nbsp;Edit Slide</h1>
        <p class="text-muted">Slide not found.</p>
        <?php
    }
} else {
    ?>
    <h1 class="page-header"><i class="fa fa-play-circle-o fa-fw"></i>&nbsp;Add Slide</h1>
    <?= output_message($message) ?>
    <form class="form-horizontal" role="form" action="slideshowpicture_edit.php" method="POST">
        <div class="form-group">
            <label for="filename" class="col-sm-2 control-label">Filename</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="filename" name="filename" placeholder="Filename" maxlength="1000" value="<?= filter_input(INPUT_POST, 'filename') ?>" required>
                <p class="help-block"><a href="media_all.php" target="_blank">Click here</a> to open the Media Library in a new tab.</p>
            </div>
        </div>
        <div class="form-group">
            <label for="wysiwyg_slide" class="col-sm-2 control-label">Caption</label>
            <div class="col-sm-10">
                <textarea id="wysiwyg_slide" name="wysiwyg_slide" class="wysisyg_slide"><?= filter_input(INPUT_POST, 'wysiwyg_slide') ?></textarea>
            </div>
        </div>
        <input type="hidden" id="slideshow" name="slideshow" value="<?=filter_input(INPUT_POST, 'slideshow') ? filter_input(INPUT_POST, 'slideshow') : filter_input(INPUT_GET, 'slideshow')?>" />
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Add" />
            </div>
        </div>
    </form>
    <?php
}
require_once(LAYOUT_PATH . DS . "admin_footer.php");
?>