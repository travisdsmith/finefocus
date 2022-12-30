<?php
$admin_page = 3;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");
if (filter_input(INPUT_POST, 'submit')) {
    if (Journal::find_by_id(filter_input(INPUT_GET, "id"))) {
        $journal = Journal::find_by_id(filter_input(INPUT_GET, "id"));
    } else {
        $journal = new Journal();
    }

    validate_presences(array('journal_name', 'datepicker'));

    if (!empty($errors)) {
        $message = "danger|There were errors. " . join(" ", $errors);
    } else {
        $journal->name = filter_input(INPUT_POST, 'journal_name');
        $journal->release_date = date("Y-m-d", strtotime(filter_input(INPUT_POST, 'datepicker')));

        if ($journal->save()) {
            $session->message("success|The journal was updated.");
            redirect_to('journal_all.php');
        } else {
            $message = "danger|The journal could not be updated.";
        }
    }
}
?>
<?php
require_once(LAYOUT_PATH . DS . "admin_header.php");
if (filter_input(INPUT_GET, "id")) {
    if ($journal = Journal::find_by_id(filter_input(INPUT_GET, "id"))) {
        ?>
        <h1 class="page-header"><i class="fa fa-book fa-fw"></i>&nbsp;Edit Journal</h1>
        <?= output_message($message) ?>
        <form class="form-horizontal" role="form" action="journal_edit.php?id=<?= $journal->id ?>" method="POST">
            <div class="form-group">
                <label for="journal_name" class="col-sm-2 control-label">Journal Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="journal_name" name="journal_name" placeholder="Journal Name" maxlength="255" value="<?= filter_input(INPUT_POST, 'journal_name') ? filter_input(INPUT_POST, 'journal_name') : $journal->name ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="datepicker" class="col-sm-2 control-label">Release Date</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Release Date" value="<?= filter_input(INPUT_POST, 'release_date') ? filter_input(INPUT_POST, 'release_date') : date("m/d/Y", strtotime($journal->release_date)) ?>" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Update" />
                </div>
            </div>
        </form>
    <?php } else { ?>
        <h1 class="page-header"><i class="fa fa-users fa-fw"></i>&nbsp;Edit Journal</h1>
        <p class="text-muted">Journal not found.</p>
        <?php
    }
} else {
    ?>
    <h1 class="page-header"><i class="fa fa-book fa-fw"></i>&nbsp;Add Journal</h1>
    <?= output_message($message) ?>
    <form class="form-horizontal" role="form" action="journal_edit.php" method="POST">
        <div class="form-group">
            <label for="journal_name" class="col-sm-2 control-label">Journal Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="journal_name" name="journal_name" placeholder="Journal Name" maxlength="255" value="<?= filter_input(INPUT_POST, 'journal_name') ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="datepicker" class="col-sm-2 control-label">Release Date</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Release Date" value="<?= filter_input(INPUT_POST, 'datepicker') ?>" required>
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