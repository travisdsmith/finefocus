<?php
$admin_page = 8;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if(!IS_DEMO){
    $max_file_size = 512000000;

    if (filter_input(INPUT_POST, 'submit')) {
        $medium = new Media();
        $medium->description = filter_input(INPUT_POST, 'description');
        $medium->attach_file($_FILES['file_upload']);
        if ($medium->save()) {
            $session->message("success|Picture uploaded successfully.");
            redirect_to('media_all.php');
        } else {
            $message = "danger|There were errors. " . join(" ", $medium->errors);
        }
    }
}

require_once(LAYOUT_PATH . DS . "admin_header.php");
?>
<h1 class="page-header"><i class="fa fa-picture-o fa-fw"></i>&nbsp;Add Picture</h1>
<?= output_message($message) ?>

<?php if(IS_DEMO){
    echo "<p>Sorry, but you cannot upload files in the demo environment.</p>";
} else {?>

<form class="form-horizontal" role="form" action="media_add.php" enctype="multipart/form-data" method="POST">
    <div class="form-group">
        <label for="file_upload" class="col-sm-2 control-label">File</label>
        <div class="col-sm-10">
            <input type="hidden" name="MAX_FILE_SIZE" value="<?= $max_file_size ?>" />
            <input type="file" name="file_upload" id="file_upload"/>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="5" name="description" id="description"><?= filter_input(INPUT_POST, 'description') != null ? filter_input(INPUT_POST, 'description') : "" ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Add" />
        </div>
    </div>
</form>
<?php }
require_once(LAYOUT_PATH . DS . "admin_footer.php");