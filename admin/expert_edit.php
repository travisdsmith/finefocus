<?php
$admin_page = 6;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");
if (filter_input(INPUT_POST, 'submit')) {
    if (Expert::find_by_id(filter_input(INPUT_GET, "id"))) {
        $expert = Expert::find_by_id(filter_input(INPUT_GET, "id"));
    } else {
        $expert = new Expert();
    }

    if (!empty($errors)) {
        $message = "danger|There were errors. " . join(" ", $errors);
    } else {
        $expert->name = filter_input(INPUT_POST, 'expert_name');
        $expert->institution = filter_input(INPUT_POST, 'institution');
        $json = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode(filter_input(INPUT_POST, 'institution'))), true);

        if ($json['status'] != "ZERO_RESULTS") {
            $expert->lat = $json['results'][0]['geometry']['location']['lat'];
            $expert->lon = $json['results'][0]['geometry']['location']['lng'];
        }

        if ($expert->save()) {
            Expert::write_to_file();
            if ($json['status'] == "ZERO_RESULTS") {
                $message = "warning|The expert was updated, but the location could not be deciphered. The expert was not added to the map. To add the expert to the map, consider adding the city, state, and country to the location.";
            } else {
                $session->message("success|The expert was updated.");
                redirect_to('expert_all.php');
            }
        } else {
            $message = "danger|The expert could not be updated.";
            echo $db->last_query;
        }
    }
}
?>
<?php
require_once(LAYOUT_PATH . DS . "admin_header.php");
if (filter_input(INPUT_GET, "id")) {
    if ($expert = Expert::find_by_id(filter_input(INPUT_GET, "id"))) {
        ?>
        <h1 class="page-header"><i class="fa fa-university fa-fw"></i>&nbsp;Edit Expert</h1>
        <?= output_message($message) ?>
        <form class="form-horizontal" role="form" action="expert_edit.php?id=<?= $expert->id ?>" method="POST">
            <div class="form-group">
                <label for="expert_name" class="col-sm-2 control-label">Expert Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="expert_name" name="expert_name" placeholder="Expert Name" maxlength="255" value="<?= filter_input(INPUT_POST, 'expert_name') ? filter_input(INPUT_POST, 'expert_name') : $expert->name ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="institution" class="col-sm-2 control-label">Institution</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="institution" name="institution" placeholder="Institution" maxlength="255" value="<?= filter_input(INPUT_POST, 'institution') ? filter_input(INPUT_POST, 'institution') : $expert->institution ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Update" />
                </div>
            </div>
        </form>
    <?php } else { ?>
        <h1 class="page-header"><i class="fa fa-university fa-fw"></i>&nbsp;Edit Expert</h1>
        <p class="text-muted">Expert not found.</p>
        <?php
    }
} else {
    ?>
    <h1 class="page-header"><i class="fa fa-university fa-fw"></i>&nbsp;Add Expert</h1>
    <?= output_message($message) ?>
    <form class="form-horizontal" role="form" action="expert_edit.php" method="POST">
        <div class="form-group">
            <label for="expert_name" class="col-sm-2 control-label">Expert Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="expert_name" name="expert_name" placeholder="Expert Name" maxlength="255" value="<?= filter_input(INPUT_POST, 'expert_name') ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="institution" class="col-sm-2 control-label">Institution</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="institution" name="institution" placeholder="Institution" maxlength="255" value="<?= filter_input(INPUT_POST, 'institution') ?>">
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