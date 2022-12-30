<?php
$admin_page = 6;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_GET, "id")) {
    $expert = Expert::find_by_id(filter_input(INPUT_GET, "id"));
    
    if ($expert) {
        if (filter_input(INPUT_POST, "confirm")) {
            if ($expert->delete()) {
                $session->message("success|The expert was deleted.");
            } else {
                $session->message("danger|Expert deletion failed.");
            }
            redirect_to("expert_all.php");
        } else {
            require_once(LAYOUT_PATH . DS . "admin_header.php")
            ?>
            <h1 class="page-header"><i class="fa fa-university fa-fw"></i>&nbsp;Delete Expert</h1>
            <div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-circle"></i> Please confirm deletion of this expert.</div>
            <form class="form-horizontal" role="form" action="expert_delete.php?id=<?= $expert->id ?>" method="POST">
                <div class="form-group">
                    <label for="expert_name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $expert->name ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="expert_name" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $expert->institution ?></p>
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
        redirect_to("expert_all.php");
    }
} else {
    redirect_to("expert_all.php");
}