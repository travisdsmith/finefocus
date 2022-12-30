<?php
require_once("../includes/initialize.php");

if ($session->is_logged_in()) {
    redirect_to("index.php");
}

// Remember to give your form's submit tag a name="submit" attribute!

if (filter_input(INPUT_POST, 'submit')) { // Form has been submitted.
    $username = trim(filter_input(INPUT_POST, 'username'));
    $password = trim(filter_input(INPUT_POST, 'password'));
    $redirect_to = trim(filter_input(INPUT_POST, 'redirect_to'));

    // Check database to see if username/password exist.
    $found_user = User::authenticate($username, $password);

    if ($found_user) {
        if ($found_user->last_login == '' || $found_user->last_login == null) {
            $quick_access = new Quick_Access();
            $quick_access->user = $found_user->id;
            $quick_access->href = "request_all.php?status=u";
            $quick_access->title = "Unfulfilled Requests";
            $quick_access->create();
        }

        $session->login($found_user);
        $session->message($db->last_query);
        $found_user->last_login = date("o-m-d H:i:s");
        $found_user->update();

        if ($redirect_to != "") {
            redirect_to($redirect_to);
        } else {
            redirect_to("index.php");
        }
    } else {
        // username/password combo was not found in the database
        $message = "danger|Your credentials were inauthentic.";
    }
} else { // Form has not been submitted.
    $username = "";
    $password = "";
}

if (filter_input(INPUT_GET, "logout") == "true") {
    $message = "info|You have successfully logged out.";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../assets/favicon.png">

        <title>Please sign in</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/bootstrap-theme.min.css" rel="stylesheet">

        <!-- FontAwesome CSS -->
        <link href="../css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="../css/signin.css" rel="stylesheet">
    </head>

    <body>

        <div class="container">
            <form class="form-signin" role="form" action="login.php" method="POST">
                <h3 class="form-signin-heading">FineFocus.org Website Administration</h3>
                <p class="text-muted">Please sign in</p>
                <?= output_message($message) ?>
                <label for="username" class="sr-only">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" value="<?= $username ?>" required autofocus>
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <input type="hidden" name="redirect_to" value="<?= filter_input(INPUT_GET, 'redirect_to') ?>">
                <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Sign In" />
                <a href="<?=BASE_URL?>" class="btn btn-lg btn-default btn-block">&laquo; Back to FineFocus.org</a>
            </form>
        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>
