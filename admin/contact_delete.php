<?php
$admin_page = 7;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_GET, "id")) {
    $contact = Contact::find_by_id(filter_input(INPUT_GET, "id"));

    if ($contact) {
        if (filter_input(INPUT_POST, "confirm")) {
            if ($contact->delete()) {
                $session->message("success|The contact was deleted.");
            } else {
                $session->message("danger|Contact deletion failed.");
            }
            redirect_to("contact_all.php");
        } else {
            require_once(LAYOUT_PATH . DS . "admin_header.php")
            ?>
            <h1 class="page-header"><i class="fa fa-envelope fa-fw"></i>&nbsp;Delete Contact</h1>
            <div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-circle"></i> Please confirm deletion of this contact.</div>
            <form class="form-horizontal" role="form" action="contact_delete.php?id=<?= $contact->id ?>" method="POST">
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
                        <p class="form-control-static"><?= Country::find_by_id($contact->country)->name ?></p>
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
        redirect_to("contact_all.php");
    }
} else {
    redirect_to("contact_all.php");
}