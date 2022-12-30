<?php
$admin_page = 8;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_POST, 'submit')) {
    $medium = Media::find_by_id(filter_input(INPUT_GET, "id"));
    $medium->description = filter_input(INPUT_POST, 'description');

    if ($medium->update()) {
        $session->message("success|The picture was updated.");
        redirect_to('media_all.php');
    } else {
        $message = "danger|The picture could not be updated.";
    }
}
?>
<?php
require_once(LAYOUT_PATH . DS . "admin_header.php");
if (filter_input(INPUT_GET, "id")) {
    if ($medium = Media::find_by_id(filter_input(INPUT_GET, "id"))) {
        ?>
        <h1 class="page-header"><i class="fa fa-picture-o fa-fw"></i>&nbsp;Edit Picture</h1>
        <?= output_message($message) ?>
        <form class="form-horizontal" role="form"  action="media_edit.php?id=<?= $medium->id ?>" method="POST">
            <div class="form-group">
                <label for="file_upload" class="col-sm-2 control-label">File</label>
                <div class="col-sm-10">
                    <a href="../<?= $medium->image_path() ?>" target="_blank"><img class="img-responsive" src="../<?= $medium->image_path() ?>" width="500" alt="Preview not available."/></a>
                    <p class="help-block">Click on the photo to view the original version.</p>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="5" name="description" id="description"><?= filter_input(INPUT_POST, 'description')!=null ? filter_input(INPUT_POST, 'description') : $medium->description ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Update" />
                </div>
            </div>
        </form>
    <?php } else {
        ?>
        <h1 class="page-header"><i class="fa fa-picture-o fa-fw"></i>&nbsp;Edit Picture</h1>
        <p class="text-muted">Picture not found.</p>
        <?php
    }
} else {
    ?>
    <h1 class="page-header"><i class="fa fa-picture-o fa-fw"></i>&nbsp;Edit Picture</h1>
    <p class="text-muted">Picture not found.</p>
    <?php
}

require_once(LAYOUT_PATH . DS . "admin_footer.php");
?>