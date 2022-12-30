<?php
$admin_page = 9;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");
if (filter_input(INPUT_POST, 'submit')) {
    if (User::find_by_id(filter_input(INPUT_GET, "id"))) {
        $user = User::find_by_id(filter_input(INPUT_GET, "id"));
    } else {
        $user = new User();
    }

    validate_presences(array('username', 'password', 'permissions'));

    if (!empty($errors)) {
        $message = "danger|There were errors. " . join(" ", $errors);
    } else {
        $user->username = filter_input(INPUT_POST, 'username');
        $user->permissions = filter_input(INPUT_POST, 'permissions');
        $user->last_login = filter_input(INPUT_POST, 'last_login');

        if (filter_input(INPUT_POST, 'password') != "") {
            $user->password = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_BCRYPT);
        }

        if ($user->save()) {
            $session->message("success|The user was updated.");
            redirect_to('user_all.php');
        } else {
            $message = "danger|The user could not be updated. Are you trying to duplicate user names?";
        }
    }
}
?>
<?php
require_once(LAYOUT_PATH . DS . "admin_header.php");
if (filter_input(INPUT_GET, "id")) {
    if ($user = User::find_by_id(filter_input(INPUT_GET, "id"))) {
        ?>
        <h1 class="page-header"><i class="fa fa-users fa-fw"></i>&nbsp;Edit User</h1>
        <?= output_message($message) ?>
        <form class="form-horizontal" role="form" action="user_edit.php?id=<?= $user->id ?>" method="POST">
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" maxlength="255" value="<?= filter_input(INPUT_POST, 'username') ? filter_input(INPUT_POST, 'username') : $user->username ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password" placeholder="(unchanged)" value="<?= filter_input(INPUT_POST, 'password') ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="permissions" class="col-sm-2 control-label">Type</label>
                <div class="col-sm-10">
                    <select class="form-control" id="permissions" name="permissions" required>
                        <?php
                        $current_permissions = filter_input(INPUT_POST, 'permissions') ? filter_input(INPUT_POST, 'permissions') : $user->permissions;
                        ?>
                        <option value="<?= FULFILLMENT_REQUEST ?>"<?= $current_permissions == FULFILLMENT_REQUEST ? " selected" : "" ?>>Request Fulfillment</option>
                        <option value="<?= STANDARD_USER ?>"<?= $current_permissions == STANDARD_USER ? " selected" : "" ?>>Standard User</option>
                        <option value="<?= ADMINISTRATOR ?>"<?= $current_permissions == ADMINISTRATOR ? " selected" : "" ?>>Administrator</option>
                        <option value="<?= PRIMARY_ADMINISTRATOR ?>"<?= $current_permissions == PRIMARY_ADMINISTRATOR ? " selected" : "" ?>>Primary Administrator</option>
                    </select>
                </div>
            </div>
            <input type="hidden" id="last_login" name="last_login" value="<?= $user->last_login ?>">
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Update" />
                </div>
            </div>
        </form>
    <?php } else { ?>
        <h1 class="page-header"><i class="fa fa-users fa-fw"></i>&nbsp;Edit User</h1>
        <p class="text-muted">User not found.</p>
        <?php
    }
} else {
    ?>
    <h1 class="page-header"><i class="fa fa-users fa-fw"></i>&nbsp;Add User</h1>
    <?= output_message($message) ?>
    <form class="form-horizontal" role="form" action="user_edit.php" method="POST">
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" maxlength="255" value="<?= filter_input(INPUT_POST, 'username') ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?= filter_input(INPUT_POST, 'password') ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="permissions" class="col-sm-2 control-label">Type</label>
            <div class="col-sm-10">
                <select class="form-control" id="permissions" name="permissions" required>
                    <?php
                        $current_permissions = filter_input(INPUT_POST, 'permissions') ? filter_input(INPUT_POST, 'permissions') : $user->permissions;
                    ?>
                    <option value="<?= FULFILLMENT_REQUEST ?>"<?= $current_permissions == FULFILLMENT_REQUEST ? " selected" : "" ?>>Request Fulfillment</option>
                    <option value="<?= STANDARD_USER ?>"<?= $current_permissions == STANDARD_USER ? " selected" : "" ?>>Standard User</option>
                    <option value="<?= ADMINISTRATOR ?>"<?= $current_permissions == ADMINISTRATOR ? " selected" : "" ?>>Administrator</option>
                    <option value="<?= PRIMARY_ADMINISTRATOR ?>"<?= $current_permissions == PRIMARY_ADMINISTRATOR ? " selected" : "" ?>>Primary Administrator</option>
                </select>
            </div>
        </div>
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