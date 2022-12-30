<?php
$admin_page = 10;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_POST, 'submit')) {
    $setting = Setting::find_by_id(filter_input(INPUT_POST, 'id'));
    $setting->value = filter_input(INPUT_POST, 'value');
    
    if ($setting->save()) {
        $message = "success|The setting was updated.";
    } else {
        $message = "danger|The setting could not be updated.";
    }
}

require_once(LAYOUT_PATH . DS . "admin_header.php");
?>
<h1 class="page-header"><i class="fa fa-cogs fa-fw"></i>&nbsp;Settings</h1>
<?= output_message($message) ?>
<form class="form-horizontal" role="form" action="settings.php" method="POST">
    <input type="hidden" name="id" value="email_request_notification">
    <div class="form-group">
        <label for="value" class="col-sm-2 control-label">Email Request Notification</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="value" placeholder="Email Request Notification" value="<?= Setting::find_by_id("email_request_notification")->value ?>">
            <p class="help-block">Which email address(es) should be notified when a new journal request comes in?
                If you want to enter in more than one email address, separate them with a comma and a space. For example: "person1@example.com, person2@example.com"</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input class="btn btn-primary" type="submit" name="submit" value="Save Change" />
        </div>
    </div>
</form>
<hr/>
<form class="form-horizontal" role="form" action="settings.php" method="POST">
    <input type="hidden" name="id" value="homepage">
    <div class="form-group">
        <label for="value" class="col-sm-2 control-label">Set Homepage</label>
        <div class="col-sm-10">
            <select class="form-control" name="value">
                <?php
                $pages = Page::find_all();
                $homepage = Setting::find_by_id("homepage")->value;
                foreach ($pages as $page) {
                    echo "<option value=\"{$page->id}\"" . ($homepage == $page->id ? " selected" : "") . ">{$page->title} ({$page->preview()})</option>" . PHP_EOL;
                }
                ?>
            </select>
            <p class="help-block">Which page should be the website's introductory page? The page title will not be shown on the homepage.</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input class="btn btn-primary" type="submit" name="submit" value="Save Change" />
        </div>
    </div>
</form>
<?php
require_once(LAYOUT_PATH . DS . "admin_footer.php");
?>