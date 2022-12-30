<?php
$admin_page = 7;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");
if (filter_input(INPUT_POST, 'submit')) {
    if (Contact::find_by_id(filter_input(INPUT_GET, "id"))) {
        $contact = Contact::find_by_id(filter_input(INPUT_GET, "id"));
    } else {
        $contact = new Contact();
        $contact->date_added = date("Y-m-d");
    }

    validate_presences(array('name', 'address1', 'city', 'state', 'postal_code', 'country', 'email'));

    if (!empty($errors)) {
        $message = "danger|There were errors. " . join(" ", $errors);
    } else {
        $contact->name = filter_input(INPUT_POST, 'name');
        $contact->address1 = filter_input(INPUT_POST, 'address1');
        $contact->address2 = filter_input(INPUT_POST, 'address2');
        $contact->city = filter_input(INPUT_POST, 'city');
        $contact->state = filter_input(INPUT_POST, 'state');
        $contact->postal_code = filter_input(INPUT_POST, 'postal_code');
        $contact->country = filter_input(INPUT_POST, 'country');
        $contact->email = filter_input(INPUT_POST, 'email');

        if ($contact->save()) {
            $session->message("success|The contact was updated.");
            redirect_to('contact_all.php');
        } else {
            $message = "danger|The contact could not be updated.";
        }
    }
}

require_once(LAYOUT_PATH . DS . "admin_header.php");
if (filter_input(INPUT_GET, "id") && Contact::find_by_id(filter_input(INPUT_GET, "id"))) {
    $contact = Contact::find_by_id(filter_input(INPUT_GET, "id"));
    ?>
    <h1 class="page-header"><i class="fa fa-envelope fa-fw"></i>&nbsp;Edit Contact</h1>
    <?= output_message($message) ?>
    <div class="table-responsive">
        <form role="form" action="contact_edit.php?id=<?= $contact->id ?>" method="POST">
            <table class="table table-striped">
                <tbody>
                    <tr><td>Name</td><td><input type="text" class="form-control" id="name" name="name" placeholder="Name" maxlength="255" value="<?= filter_input(INPUT_POST, 'name') ? filter_input(INPUT_POST, 'name') : $contact->name ?>" required></td></tr>
                    <tr><td>Address 1</td><td><input type="text" class="form-control" id="address1" name="address1" placeholder="Address 1" maxlength="255" value="<?= filter_input(INPUT_POST, 'address1') ? filter_input(INPUT_POST, 'address1') : $contact->address1 ?>" required></td></tr>
                    <tr><td>Address 2</td><td><input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2" maxlength="255" value="<?= filter_input(INPUT_POST, 'address2') ? filter_input(INPUT_POST, 'address2') : $contact->address2 ?>"></td></tr>
                    <tr><td>City</td><td><input type="text" class="form-control" id="city" name="city" placeholder="City" maxlength="75" value="<?= filter_input(INPUT_POST, 'city') ? filter_input(INPUT_POST, 'city') : $contact->city ?>" required></td></tr>
                    <tr><td>State</td><td><input type="text" class="form-control" id="state" name="state" placeholder="State" maxlength="75" value="<?= filter_input(INPUT_POST, 'state') ? filter_input(INPUT_POST, 'state') : $contact->state ?>" required></td></tr>
                    <tr><td>Postal Code</td><td><input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" maxlength="45" value="<?= filter_input(INPUT_POST, 'postal_code') ? filter_input(INPUT_POST, 'postal_code') : $contact->postal_code ?>" required></td></tr>
                    <tr><td>Country</td>
                        <td>
                            <select name="country" id="country" name="country" class="form-control" required>
                                <?php
                                $countries = Country::find_all();
                                $selected_country = filter_input(INPUT_POST, "country") ? filter_input(INPUT_POST, "country") : "US";
                                foreach ($countries as $country) {
                                    if ($selected_country == $country->id) {
                                        echo "<option value=\"$country->id\" selected>$country->name</option>" . PHP_EOL;
                                    } else {
                                        echo "<option value=\"$country->id\">$country->name</option>" . PHP_EOL;
                                    }
                                }
                                ?>
                            </select>
                        </td></tr>
                    <tr><td>Email</td><td><input type="email" class="form-control" id="email" name="email" placeholder="Email" maxlength="255" value="<?= filter_input(INPUT_POST, 'email') ? filter_input(INPUT_POST, 'email') : $contact->email ?>" required></td></tr>
                    <tr><td>Date Added</td><td><?= date("m/d/Y", strtotime($contact->date_added)) ?></td></tr>
                    <tr><td>Notes</td><td><textarea id="notes" name="notes" class="form-control" placeholder="Notes"><?= filter_input(INPUT_POST, 'notes') ? filter_input(INPUT_POST, 'notes') : $contact->notes ?></textarea></td></tr>
                </tbody>
            </table>
            <div style="text-align:center"><input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Update" /></div>
        </form>
    </div>
<?php } else {
    ?>
    <h1 class="page-header"><i class="fa fa-envelope fa-fw"></i>&nbsp;Add Contact</h1>
    <?= output_message($message) ?>
    <div class="table-responsive">
        <form role="form" action="contact_edit.php" method="POST">
            <table class="table table-striped">
                <tbody>
                    <tr><td>Name</td><td><input type="text" class="form-control" id="name" name="name" placeholder="Name" maxlength="255" value="<?= filter_input(INPUT_POST, 'name') ?>" required></td></tr>
                    <tr><td>Address 1</td><td><input type="text" class="form-control" id="address1" name="address1" placeholder="Address 1" maxlength="255" value="<?= filter_input(INPUT_POST, 'address1') ?>" required></td></tr>
                    <tr><td>Address 2</td><td><input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2" maxlength="255" value="<?= filter_input(INPUT_POST, 'address2') ?>"></td></tr>
                    <tr><td>City</td><td><input type="text" class="form-control" id="city" name="city" placeholder="City" maxlength="75" value="<?= filter_input(INPUT_POST, 'city') ?>" required></td></tr>
                    <tr><td>State</td><td><input type="text" class="form-control" id="state" name="state" placeholder="State" maxlength="75" value="<?= filter_input(INPUT_POST, 'state') ?>" required></td></tr>
                    <tr><td>Postal Code</td><td><input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" maxlength="45" value="<?= filter_input(INPUT_POST, 'postal_code') ?>" required></td></tr>
                    <tr><td>Country</td>
                        <td>
                            <select name="country" id="country" name="country" class="form-control" required>
                                <?php
                                $countries = Country::find_all();
                                $selected_country = filter_input(INPUT_POST, "country") ? filter_input(INPUT_POST, "country") : "US";
                                foreach ($countries as $country) {
                                    if ($selected_country == $country->id) {
                                        echo "<option value=\"$country->id\" selected>$country->name</option>" . PHP_EOL;
                                    } else {
                                        echo "<option value=\"$country->id\">$country->name</option>" . PHP_EOL;
                                    }
                                }
                                ?>
                            </select>
                        </td></tr>
                    <tr><td>Email</td><td><input type="email" class="form-control" id="email" name="email" placeholder="Email" maxlength="255" value="<?= filter_input(INPUT_POST, 'email') ?>" required></td></tr>
                    <tr><td>Notes</td><td><textarea id="notes" name="notes" class="form-control" placeholder="Notes"><?= filter_input(INPUT_POST, 'notes') ?></textarea></td></tr>
                </tbody>
            </table>
            <div style="text-align:center"><input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Add" /></div>
        </form>
    </div>
    <?php
}
require_once(LAYOUT_PATH . DS . "admin_footer.php");
?>