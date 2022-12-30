<?php
$admin_page = 5;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");
if (filter_input(INPUT_POST, 'submit')) {
    $slideshow = Slideshow::find_by_id(filter_input(INPUT_GET, "id"));
    $slideshow->slug = filter_input(INPUT_POST, 'slug');
    $slideshow->description = filter_input(INPUT_POST, 'description');
    $slideshow->slide = filter_input(INPUT_POST, 'slide');
    $slideshow->indicators = filter_input(INPUT_POST, 'indicators');
    $slideshow->controls = filter_input(INPUT_POST, 'controls');
    $slideshow->interval = filter_input(INPUT_POST, 'interval');
    $slideshow->pause = filter_input(INPUT_POST, 'pause');
    $slideshow->wrap = filter_input(INPUT_POST, 'wrap');
    
    if ($slideshow->save()) {
        $session->message("success|Slideshow successfully updated.");
        redirect_to('slideshow_edit.php?id=' . $slideshow->id);
    } else {
        $message = "danger|Slideshow update unsuccessful.";
    }
}

require_once(LAYOUT_PATH . DS . "admin_header.php");
?>
<h1 class="page-header"><i class="fa fa-play-circle-o fa-fw"></i>&nbsp;Edit Slideshow</h1>
<?= output_message($message); ?>

<?php
if (filter_input(INPUT_GET, "id")) {
    if ($slideshow = Slideshow::find_by_id(filter_input(INPUT_GET, "id"))) {
        ?>
        <form class="form-horizontal" role="form" action="slideshow_edit.php?id=<?=$slideshow->id?>" method="POST">
            <div class="form-group">
                <label for="slug" class="col-sm-2 control-label">Slug</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" maxlength="45" value="<?= $slideshow->slug ?>" required>
                    <p class="help-block">The slug is a human-readable name that uniquely identifies the slideshow. No two slideshows may have the same slug.</p>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="5" name="description" id="description"><?= $slideshow->description ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="slide" class="col-sm-2 control-label">Animation</label>
                <div class="col-sm-10">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default<?= $slideshow->slide == 1 ? " active" : "" ?>">
                            <input type="radio" name="slide" autocomplete="off" value="1"<?= $slideshow->slide == 1 ? " checked" : "" ?>> Slide
                        </label>
                        <label class="btn btn-default<?= $slideshow->slide == 0 ? " active" : "" ?>">
                            <input type="radio" name="slide" autocomplete="off" value="0"<?= $slideshow->slide == 0 ? " checked" : "" ?>> None
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="indicators" class="col-sm-2 control-label">Indicators</label>
                <div class="col-sm-10">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default<?= $slideshow->indicators == 1 ? " active" : "" ?>">
                            <input type="radio" name="indicators" autocomplete="off" value="1"<?= $slideshow->indicators == 1 ? " checked" : "" ?>> Show
                        </label>
                        <label class="btn btn-default<?= $slideshow->indicators == 0 ? " active" : "" ?>">
                            <input type="radio" name="indicators" autocomplete="off" value="0"<?= $slideshow->indicators == 0 ? " checked" : "" ?>> Hide
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="controls" class="col-sm-2 control-label">Controls</label>
                <div class="col-sm-10">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default<?= $slideshow->controls == 1 ? " active" : "" ?>">
                            <input type="radio" name="controls" autocomplete="off" value="1"<?= $slideshow->controls == 1 ? " checked" : "" ?>> Show
                        </label>
                        <label class="btn btn-default<?= $slideshow->controls == 0 ? " active" : "" ?>">
                            <input type="radio" name="controls" autocomplete="off" value="0"<?= $slideshow->controls == 0 ? " checked" : "" ?>> Hide
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="interval" class="col-sm-2 control-label">Auto Change</label>
                <div class="col-sm-10">
                    <select class="form-control" id="interval" name="interval">
                        <option value="false"<?= $slideshow->interval == "false" ? " selected" : "" ?>>Off</option>
                        <option value="1000"<?= $slideshow->interval == "1000" ? " selected" : "" ?>>1 second</option>
                        <option value="2000"<?= $slideshow->interval == "2000" ? " selected" : "" ?>>2 seconds</option>
                        <option value="3000"<?= $slideshow->interval == "3000" ? " selected" : "" ?>>3 seconds</option>
                        <option value="4000"<?= $slideshow->interval == "4000" ? " selected" : "" ?>>4 seconds</option>
                        <option value="5000"<?= $slideshow->interval == "5000" ? " selected" : "" ?>>5 seconds</option>
                        <option value="6000"<?= $slideshow->interval == "6000" ? " selected" : "" ?>>6 seconds</option>
                        <option value="7000"<?= $slideshow->interval == "7000" ? " selected" : "" ?>>7 seconds</option>
                        <option value="8000"<?= $slideshow->interval == "8000" ? " selected" : "" ?>>8 seconds</option>
                        <option value="9000"<?= $slideshow->interval == "19000" ? " selected" : "" ?>>9 seconds</option>
                        <option value="10000"<?= $slideshow->interval == "10000" ? " selected" : "" ?>>10 seconds</option>
                        <option value="15000"<?= $slideshow->interval == "15000" ? " selected" : "" ?>>15 seconds</option>
                        <option value="30000"<?= $slideshow->interval == "30000" ? " selected" : "" ?>>30 seconds</option>
                        <option value="45000"<?= $slideshow->interval == "45000" ? " selected" : "" ?>>45 seconds</option>
                        <option value="60000"<?= $slideshow->interval == "60000" ? " selected" : "" ?>>60 seconds</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="pause" class="col-sm-2 control-label">Pause on Hover</label>
                <div class="col-sm-10">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default<?= $slideshow->pause == 1 ? " active" : "" ?>">
                            <input type="radio" name="pause" autocomplete="off" value="1"<?= $slideshow->pause == 1 ? " checked" : "" ?>> Yes
                        </label>
                        <label class="btn btn-default<?= $slideshow->pause == 0 ? " active" : "" ?>">
                            <input type="radio" name="pause" autocomplete="off" value="0"<?= $slideshow->pause == 0 ? " checked" : "" ?>> No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="wrap" class="col-sm-2 control-label">Repeat</label>
                <div class="col-sm-10">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default<?= $slideshow->wrap == 1 ? " active" : "" ?>">
                            <input type="radio" name="wrap" autocomplete="off" value="1"<?= $slideshow->wrap == 1 ? " checked" : "" ?>> Yes
                        </label>
                        <label class="btn btn-default<?= $slideshow->wrap == 0 ? " active" : "" ?>">
                            <input type="radio" name="wrap" autocomplete="off" value="0"<?= $slideshow->wrap == 0 ? " checked" : "" ?>> No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Update" />
                </div>
            </div>
        </form>

        <br/>

        <h2>Slideshow Pictures&nbsp;<a class="btn btn-default" href="slideshowpicture_edit.php?slideshow=<?=$slideshow->id?>" role="button" data-toggle="tooltip" data-placement="top" title="Add"><i class="fa fa-plus fa-fw"></i></a></h2>

        <?php
        $slideshow_pictures = Slideshow_Picture::find_by_slideshow_id($slideshow->id);
        $total_count = Slideshow_Picture::count_by_slideshow_id($slideshow->id);

        if ($slideshow_pictures) {
            echo "<p class=\"lead\">Total Count: " . $total_count . "</p>";
            echo "<div class=\"table-responsive\">" . PHP_EOL;
            echo "<table class=\"table table-striped\">" . PHP_EOL;
            echo "<thead>" . PHP_EOL;
            echo "<tr>" . PHP_EOL;
            echo "<th>Picture</th>" . PHP_EOL;
            echo "<th>Caption</th>" . PHP_EOL;
            echo "<th></th>" . PHP_EOL;
            echo "</tr>" . PHP_EOL;
            echo "</thead>" . PHP_EOL;
            echo "<tbody>" . PHP_EOL;
            foreach ($slideshow_pictures as $slideshow_picture) {
                echo "<tr>" . PHP_EOL;
                echo "<td><a href=\"{$slideshow_picture->filename}\" target=\"_blank\"><img src=\"{$slideshow_picture->filename}\" width=\"200\" alt=\"Preview not available.\"/></a></td>" . PHP_EOL;
                echo "<td>" . $slideshow_picture->caption . "</td>" . PHP_EOL;
                echo "<td>" . PHP_EOL;
                echo "<div style=\"white-space:nowrap;text-align:right;\">";
                echo "<a class=\"btn btn-primary btn-xs\" href=\"slideshowpicture_edit.php?id={$slideshow_picture->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>";
                echo "&nbsp;";
                echo "<a class=\"btn btn-danger btn-xs\" href=\"slideshowpicture_delete.php?id={$slideshow_picture->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete\"><i class=\"fa fa-trash\"></i></a>";
                echo "</div>";
                echo "</td>" . PHP_EOL;
                echo "</tr>" . PHP_EOL;
            }
            echo "</tbody>" . PHP_EOL;
            echo "</table>" . PHP_EOL;
            echo "</div>" . PHP_EOL;
        } else {
            echo "<p class=\"text-muted\">No pictures have been added to this slideshow.</p>";
        }
        ?>

        <?php
    } else {
        echo "<p class=\"text-muted\">Slideshow not found.</p>";
    }
} else {
    echo "<p class=\"text-muted\">Slideshow not found.</p>";
}
require_once(LAYOUT_PATH . DS . "admin_footer.php");
