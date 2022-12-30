<?php require_once("includes/initialize.php"); ?>
<?php require_once 'layouts/header.php' ?>
<?php
if (filter_input(INPUT_POST, 'submit')) {
    $journal = filter_input(INPUT_POST, 'journal');
    $type = filter_input(INPUT_POST, 'type');
    $name = filter_input(INPUT_POST, 'name');
    $address_1 = filter_input(INPUT_POST, 'address_1');
    $address_2 = filter_input(INPUT_POST, 'address_2');
    $city = filter_input(INPUT_POST, 'city');
    $state = filter_input(INPUT_POST, 'state');
    $postal = filter_input(INPUT_POST, 'postal');
    $country = filter_input(INPUT_POST, 'country');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $comments = filter_input(INPUT_POST, 'comments');
    $referer = filter_input(INPUT_POST, 'referer');
    $info = filter_input(INPUT_POST, 'info');

    validate_presences(array('journal', 'type', 'name', 'address_1', 'city', 'state', 'postal', 'country', 'email'));

    if (!empty($errors)) {
        $message = "danger|There were errors. " . join(" ", $errors);
    } else {
        $request = new Request();
        $request->request_date = date("Y-m-d");
        $request->request_type = $type;
        $request->name = $name;
        $request->address1 = $address_1;
        $request->address2 = $address_2;
        $request->city = $city;
        $request->state = $state;
        $request->postal_code = $postal;
        $request->country = $country;
        $request->email = $email;
        $request->requested_journal = $journal;
        $request->additional_comments = $comments;
        $request->fulfillment_status = "u";
        $request->referer = $referer;

        if ($request->create()) {
            //$to = Setting::find_by_id('email_request_notification')->value;
            $subject = "JOURNAL REQUEST";
            $txt = "A new journal request has just come in. Please visit http://finefocus.org/admin/orders_to_fulfill.php to view unfulfilled requests.";
            $headers = "From: finefocus@bsu.edu";

            mail($to, $subject, $txt, $headers);

            $message = "success|Thank you for your interest in Fine Focus Journal. Your request number is {$request->id}.";

            if ($info) {
                $contact = new Contact();
                $contact->name = $name;
                $contact->address1 = $address_1;
                $contact->address2 = $address_2;
                $contact->city = $city;
                $contact->state = $state;
                $contact->postal_code = $postal;
                $contact->country = $country;
                $contact->email = $email;
                $contact->date_added = strftime("%Y-%m-%d", time());
                $contact->create();
            }
        } else {
            $message = "danger|Sorry, we could not create your request. Please contact us to complete the request. We apologize for the inconvenience.";
        }
    }
}
?>
<div class="col-md-3"></div>
<div class="col-md-9">
    <h1>Journals</h1>
    <h2>View Online</h2>
    <p><a href="https://cardinalscholar.bsu.edu/handle/123456789/199369">Click Here</a> to go to Cardinal Scholar and view the journal online.</p>
    <h2>Request a Copy</h2>
    <?= output_message($message) ?>
    <p>Fill out this form to request a free copy of <i>Fine Focus</i> journal. Required fields are marked with an asterisk (*). </p>
    <form action="journals.php" method="POST">
        <div class="form-group">
            <label for="journal">Journal*</label>
            <select name="journal" class="form-control">
                <?php
                $journals = Journal::find_all();
                foreach ($journals as $journal) {
                    if (filter_input(INPUT_POST, "journal") == $journal->id) {
                        echo "<option value=\"$journal->id\" selected>$journal->name</option>" . PHP_EOL;
                    } else {
                        echo "<option value=\"$journal->id\">$journal->name</option>" . PHP_EOL;
                    }
                }
                ?>
            </select>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="type" id="type" value="p"<?= filter_input(INPUT_POST, "type") == 'p' || !filter_input(INPUT_POST, "type") ? " checked" : "" ?>>
                I'm going to read this journal for myself.
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="type" id="type" value="o"<?= filter_input(INPUT_POST, "type") == 'o' ? " checked" : "" ?>>
                I want this journal for something like a library or a class.
            </label>
        </div>
        <div class="form-group">
            <label for="name">Name*</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="(required)" value="<?= filter_input(INPUT_POST, "name") ?>" maxlength="255">
        </div>
        <div class="form-group">
            <label for="address_line_1">Address Line 1*</label>
            <input type="text" class="form-control" id="address_line_1" name="address_line_1" placeholder="(required)" value="<?= filter_input(INPUT_POST, "address_line_1") ?>" maxlength="255">
        </div>
        <div class="form-group">
            <label for="address_line_2">Address Line 2</label>
            <input type="text" class="form-control" id="address_line_2" name="address_line_2" placeholder="(optional)" value="<?= filter_input(INPUT_POST, "address_line_2") ?>" maxlength="255">
        </div>
        <div class="form-group">
            <label for="city">City*</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="(required)" value="<?= filter_input(INPUT_POST, "city") ?>" maxlength="75">
        </div>
        <div class="form-group">
            <label for="state">State/Province*</label>
            <input type="text" class="form-control" id="state" name="state" placeholder="(required)" value="<?= filter_input(INPUT_POST, "state") ?>" maxlength="75">
        </div>
        <div class="form-group">
            <label for="postal">Postal Code*</label>
            <input type="text" class="form-control" id="postal" name="postal" placeholder="(required)" value="<?= filter_input(INPUT_POST, "postal") ?>" maxlength="15">
        </div>
        <div class="form-group">
            <label for="country">Country*</label>
            <select name="country" id="country" name="country" class="form-control">
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
        </div>
        <div class="form-group">
            <label for="email">Email Address*</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="(required)" value="<?= filter_input(INPUT_POST, "email") ?>" maxlength="255">
            <p class="help-block">We're collecting this in case we need to contact you with
                a problem. If we are unable to resolve any issues with
                your request, you may not receive a journal.
                Don't worry... We won't send you any unsolicited messages.</p>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="info" checked> Yes! I want more information about <i>Fine Focus</i>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="referer">How did you hear about us?</label>
            <input type="text" class="form-control" id="referer" name="referer" placeholder="(optional)" value="<?= filter_input(INPUT_POST, "referer") ?>" maxlength="45">
        </div>
        <div class="form-group">
            <label for="comment">Additional Comments</label>
            <p class="help-block">Is there anything else you'd like to communicate with us?</p>
            <textarea class="form-control" rows="5" name="comments" placeholder="(optional)" id="comments"><?= filter_input(INPUT_POST, "comments") ?></textarea>
        </div>
        <input class="btn btn-default btn-lg" type="submit" name="submit" value="Submit Your Request">
    </form>
</div>
<?php require_once 'layouts/footer.php' ?>