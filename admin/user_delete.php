<?php
$admin_page = 9;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_GET, "id")) {
    $user = User::find_by_id(filter_input(INPUT_GET, "id"));
    
    if ($user) {
        if (filter_input(INPUT_POST, "confirm")) {
            $quick_access_items = Quick_Access::find_by_user($user->id);
            foreach($quick_access_items as $quick_access_item){
                $quick_access_item->delete();
            }
            if ($user->delete()) {
                $session->message("success|The user was deleted.");
            } else {
                $session->message("danger|User deletion failed.");
            }
            redirect_to("user_all.php");
        } else {
            require_once(LAYOUT_PATH . DS . "admin_header.php")
            ?>
            <h1 class="page-header"><i class="fa fa-users fa-fw"></i>&nbsp;Delete User</h1>
            <div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-circle"></i> Please confirm deletion of this user.</div>
            <form class="form-horizontal" role="form" action="user_delete.php?id=<?= $user->id ?>" method="POST">
                <div class="form-group">
                    <label for="user_name" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $user->username ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="user_name" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">(hidden)</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="user_name" class="col-sm-2 control-label">Type</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $user->get_type() ?></p>
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
        redirect_to("user_all.php");
    }
} else {
    redirect_to("user_all.php");
}