<?php
$admin_page = 3;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_GET, "id")) {
    $journal = Journal::find_by_id(filter_input(INPUT_GET, "id"));

    if ($journal) {
        if (filter_input(INPUT_POST, "confirm")) {
            if ($journal->delete()) {
                $session->message("success|The journal was deleted.");
            } else {
                $session->message("danger|Journal deletion failed.");
            }
            redirect_to("journal_all.php");
        } else {
            require_once(LAYOUT_PATH . DS . "admin_header.php")
            ?>
            <h1 class="page-header"><i class="fa fa-book fa-fw"></i>&nbsp;Delete Journal</h1>
            <div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-circle"></i> Please confirm deletion of this journal.</div>
            <form class="form-horizontal" role="form" action="journal_delete.php?id=<?= $journal->id ?>" method="POST">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $contact->name ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address1" class="col-sm-2 control-label">Address 1</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $contact->address1 ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address2" class="col-sm-2 control-label">Address 2</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $contact->address2 ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="city" class="col-sm-2 control-label">City</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $contact->city ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="state" class="col-sm-2 control-label">State</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $contact->state ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="postal_code" class="col-sm-2 control-label">Postal Code</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $contact->postal_code ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="country" class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= Country::find_by_id($contact->country->name) ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $contact->email ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="date_added" class="col-sm-2 control-label">Date Added</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= date("m/d/Y", strtotime($contact->date_added)) ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes" class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $contact->notes ?></p>
                    </div>
                </div>
            </form>

            <?php
            require_once(LAYOUT_PATH . DS . "admin_footer.php");
        }
    } else {
        redirect_to("journal_all.php");
    }
} else {
    redirect_to("journal_all.php");
}