<?php
$admin_page = 2;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");
if (filter_input(INPUT_POST, 'submit')) {
    $request = Request::find_by_id(filter_input(INPUT_GET, "id"));
    $request->fulfillment_status = filter_input(INPUT_POST, 'fulfillment_status');
    $request->fulfillment_date = date("Y-m-d");
    $request->notes = filter_input(INPUT_POST, 'notes');

    if ($request->save()) {
        $session->message("success|The request was updated.");
        redirect_to('request_all.php');
    } else {
        $message = "danger|The request could not be updated.";
    }
}
if (filter_input(INPUT_GET, "id") && Request::find_by_id(filter_input(INPUT_GET, "id"))) {
    $request = Request::find_by_id(filter_input(INPUT_GET, "id"));
    require_once(LAYOUT_PATH . DS . "admin_header.php");
    ?>
    <h1 class="page-header"><i class="fa fa-pencil-square-o fa-fw"></i>&nbsp;Edit Request</h1>
    <?= output_message($message) ?>
    <div class="table-responsive">
        <form role="form" action="request_edit.php?id=<?= $request->id ?>" method="POST">
            <table class="table table-striped">
                <tbody>
                    <tr><td>Request Date</td><td><?= date("m/d/Y", strtotime($request->request_date)) ?></td></tr>
                    <tr><td>Request Type</td><td><?= $request->get_type() ?></td></tr>
                    <tr><td>Name</td><td><?= $request->name ?></td></tr>
                    <tr><td>Address Line 1</td><td><?= $request->address_1 ?></td></tr>
                    <tr><td>Address Line 2</td><td><?= $request->address_2 ?></td></tr>
                    <tr><td>City</td><td><?= $request->city ?></td></tr>
                    <tr><td>State</td><td><?= $request->state ?></td></tr>
                    <tr><td>Postal Code</td><td><?= $request->postal_code ?></td></tr>
                    <tr><td>Country</td><td><?= Country::find_by_id($request->country)->name ?></td></tr>
                    <tr><td>Journal</td><td><?= Journal::find_by_id($request->requested_journal)->name ?></td></tr>
                    <tr><td>Email Address</td><td><?= $request->email ?></td></tr>
                    <tr><td>Referer</td><td><?= $request->referer ?></td></tr>
                    <tr><td>Additional Comments</td><td><?= $request->additional_comments ?></td></tr>
                    <tr><td>Fulfillment Status</td><td>
                            <select class="form-control" id="fulfillment_status" name="fulfillment_status">
                                <option value="1"<?= $request->fulfillment_status == 1 ? " selected" : "" ?>>Fulfilled</option>
                                <option value="-1"<?= $request->fulfillment_status == -1 ? " selected" : "" ?>>Rejected</option>
                            </select>
                        </td></tr>
                    <tr><td>Fulfillment Date</td><td><?= date("m/d/Y", strtotime($request->fulfillment_date)) ?></td></tr>
                    <tr><td>Notes</td><td><textarea id="notes" name="notes" class="form-control"><?= $request->notes ?></textarea></td></tr>
                </tbody>
            </table>
            <div style="text-align:center"><input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Update" /></div>
        </form>
    </div>
    <?php require_once(LAYOUT_PATH . DS . "admin_footer.php"); ?>
    <?php
} else {
    redirect_to("request_all.php");
}