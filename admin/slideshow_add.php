<?php
$admin_page = 5;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_POST, 'submit')) {
    $slideshow = new Slideshow();
    $slideshow->slug = filter_input(INPUT_POST, 'slug');
    $slideshow->description = filter_input(INPUT_POST, 'description');
    $slideshow->slide = filter_input(INPUT_POST, 'slide');
    $slideshow->indicators = filter_input(INPUT_POST, 'indicators');
    $slideshow->controls = filter_input(INPUT_POST, 'controls');
    $slideshow->interval = filter_input(INPUT_POST, 'interval');
    $slideshow->pause = filter_input(INPUT_POST, 'pause');
    $slideshow->wrap = filter_input(INPUT_POST, 'wrap');
    
    if ($slideshow->create()) {
        $session->message("success|Slideshow successfully created. You can now populate the slideshow with pictures.");
        redirect_to('slideshow_edit.php?id=' . $db->insert_id());
    } else {
        $message = "danger|Slideshow creation unsuccessful.";
    }
}
?>

<?php require_once(LAYOUT_PATH . DS . "admin_header.php"); ?>

<h1 class="page-header"><i class="fa fa-play-circle-o fa-fw"></i>&nbsp;Add Slideshow</h1>
<?= output_message($message) ?>
<form class="form-horizontal" role="form" action="slideshow_add.php" method="POST">
    <div class="form-group">
        <label for="slug" class="col-sm-2 control-label">Slug</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" maxlength="45" value="" required>
            <p class="help-block">The slug is a human-readable name that uniquely identifies the slideshow. No two slideshows may have the same slug.</p>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="5" name="description" id="description"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="slide" class="col-sm-2 control-label">Animation</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default active">
                    <input type="radio" name="slide" autocomplete="off" value="1" checked> Slide
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="slide" autocomplete="off" value="0"> None
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="indicators" class="col-sm-2 control-label">Indicators</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default active">
                    <input type="radio" name="indicators" autocomplete="off" value="1" checked> Show
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="indicators" autocomplete="off" value="0"> Hide
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="controls" class="col-sm-2 control-label">Controls</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default active">
                    <input type="radio" name="controls" autocomplete="off" value="1" checked> Show
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="controls" autocomplete="off" value="0"> Hide
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="interval" class="col-sm-2 control-label">Auto Change</label>
        <div class="col-sm-10">
            <select class="form-control" id="interval" name="interval">
                <option value="false">Off</option>
                <option value="1000">1 second</option>
                <option value="2000">2 seconds</option>
                <option value="3000">3 seconds</option>
                <option value="4000">4 seconds</option>
                <option value="5000" selected>5 seconds</option>
                <option value="6000">6 seconds</option>
                <option value="7000">7 seconds</option>
                <option value="8000">8 seconds</option>
                <option value="9000">9 seconds</option>
                <option value="10000">10 seconds</option>
                <option value="15000">15 seconds</option>
                <option value="30000">30 seconds</option>
                <option value="45000">45 seconds</option>
                <option value="60000">60 seconds</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="pause" class="col-sm-2 control-label">Pause on Hover</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default active">
                    <input type="radio" name="pause" autocomplete="off" value="1" checked> Yes
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="pause" autocomplete="off" value="0"> No
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="wrap" class="col-sm-2 control-label">Repeat</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default active">
                    <input type="radio" name="wrap" autocomplete="off" value="1" checked> Yes
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="wrap" autocomplete="off" value="0"> No
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Create and Add Slides" />
        </div>
    </div>
</form>

<?php
require_once(LAYOUT_PATH . DS . "admin_footer.php");
