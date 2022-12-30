<?php
$admin_page=0;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");
require_once(LAYOUT_PATH . DS . "admin_header.php");?>
<div class="alert alert-danger" role="alert"><i class="fa fa-times-circle"></i> You do not have access to this page. If you believe you have received this message in error, please contact your administrator.</div>
<?php require_once(LAYOUT_PATH . DS . "admin_footer.php");