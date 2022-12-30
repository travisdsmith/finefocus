<?php
$admin_page = 11;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_POST, "submit")) {
    $session->logout();
    redirect_to("../kiosk/");
}

require_once(LAYOUT_PATH . DS . "admin_header.php")
?>
<h1 class="page-header"><i class="fa fa-television fa-fw"></i>&nbsp;Kiosk Mode</h1>
<?= output_message($message) ?>
<p>You are about to enter Kiosk Mode.</p>
<p>Kiosk Mode is a simplified version of
    <a href="http://finefocus.org">FineFocus.org</a>
    that can be pulled up at conferences.
    It allows users to request journals, request more information,
    and browse the entire website without overshadowing
    the speakers and visual aids</p>
<p>Here is an explanation of the parts of Kiosk Mode:</p>
<ul>
    <li>"Request a Journal" allows viewers to request a copy of Fine Focus and optionally request more information.</li>
    <li>"Request More Information" allows viewers to submit their contact information to us.</li>
    <li>"Visit our Website" opens finefocus.org in a new window.</li>
</ul>
<p>Some things to keep in mind:</p>
<ul>
    <li>To keep things as professional as possible, don't type
        abbreviations into the Conference Name box on the next screen.
        Instead, try to spell out as many things as you can.</li>
    <li>To exit Kiosk Mode, close all browser windows or go to http://finefocus.org/kiosk/logout.</li>
    <li>For best results, present Kiosk Mode in full screen.</li>
</ul>
<p>Click the button below to enter Kiosk Mode. When you enter Kisok Mode, you will be logged out of Website Administration.</p>
<form action="kiosk.php" method="POST">
    <input class="btn btn-default btn-lg" type="submit" name="submit" id="submit" value="Enter Kiosk Mode">
</form>
<?php
require_once(LAYOUT_PATH . DS . "admin_footer.php");
