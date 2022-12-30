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

        <title>Fine Focus - Website Administration</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/bootstrap-theme.min.css" rel="stylesheet">

        <!-- FontAwesome CSS -->
        <link href="../css/font-awesome.min.css" rel="stylesheet">

        <!-- JQuery UI CSS -->
        <link href="../css/jquery-ui.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="../css/admin.css" rel="stylesheet">
    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Website Administration</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown visible-xs">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars fa-fw"></i>&nbsp;Admin Sidebar <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php
                                for ($i = 1; $i <= Admin_Menu::find_max_group(); $i++) {
                                    $menu_items = Admin_Menu::find_by_group($i);
                                    foreach ($menu_items as $menu_item) {
                                        if ($menu_item->permissions <= User::find_by_id($session->user_id->id)->permissions) {
                                            if ($admin_page == $menu_item->id) {
                                                echo "<li class=\"active\"><a href=\"{$menu_item->href}\"><i class=\"fa fa-{$menu_item->icon} fa-fw\"></i>&nbsp;{$menu_item->title} <span class=\"sr-only\">(current)</span></a></li>" . PHP_EOL;
                                            } else {
                                                echo "<li><a href=\"{$menu_item->href}\"><i class=\"fa fa-{$menu_item->icon} fa-fw\"></i>&nbsp;{$menu_item->title}</a></li>" . PHP_EOL;
                                            }
                                        }
                                    }
                                    echo Admin_Menu::find_max_group() == $i ? "" : "<li role=\"separator\" class=\"divider\"></li>";
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bookmark fa-fw"></i>&nbsp;Bookmarks <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php
                                $quick_access_items = Quick_Access::find_by_user($session->user_id->id);
                                $in_quick_access = false;
                                if (count($quick_access_items) > 0) {
                                    foreach ($quick_access_items as $quick_access_item) {
                                        echo "<li><a href=\"{$quick_access_item->href}\">{$quick_access_item->title}</a></li>" . PHP_EOL;
                                        substr(strrchr(filter_input(INPUT_SERVER, "REQUEST_URI"), "/"), 1) == $quick_access_item->href ? $in_quick_access = true : null;
                                    }
                                    echo "<li role=\"separator\" class=\"divider\"></li>";
                                }

                                if ($in_quick_access) {
                                    echo "<li><a href = \"quick_access.php?action=remove&href=" . substr(strrchr(filter_input(INPUT_SERVER, "REQUEST_URI"), "/"), 1) . "\"><i class = \"fa fa-minus-square fa-fw\"></i>&nbsp;Remove current page</a></li>";
                                } else {
                                    ?><li class="dropdown-header"><strong>Add current page to Bookmarks</strong></li>
                                    <li class="dropdown-header">Type label then press <kbd>Enter</kbd>.</li>
                                    <li>
                                        <a>
                                            <form action="quick_access.php" method="GET">
                                                <input type="text" class="form-control" name="title" id="title" placeholder="Menu Label">
                                                <input type="hidden" name="href" id="href" value="<?= substr(strrchr(filter_input(INPUT_SERVER, "REQUEST_URI"), "/"), 1) ?>">
                                                <input type="hidden" name="action" id="action" value="add">
                                            </form>
                                        </a>
                                    </li><?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-fw"></i>&nbsp;<?= User::find_by_id($session->user_id->id)->username ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="password.php"><i class="fa fa-key fa-fw"></i>&nbsp;Change Password</a></li>
                                <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i>&nbsp;Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="navbar-form navbar-right" action="search.php" method="GET">
                        <input type="text" class="form-control" name="search" id="search" placeholder="Search...">
                    </form>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <?php
                    for ($i = 1; $i <= Admin_Menu::find_max_group(); $i++) {
                        if (Admin_Menu::find_group_permissions($i) <= User::find_by_id($session->user_id->id)->permissions){
                            echo "<ul class=\"nav nav-sidebar\">" . PHP_EOL;
                        }
                        $menu_items = Admin_Menu::find_by_group($i);
                        foreach ($menu_items as $menu_item) {
                            if ($menu_item->permissions <= User::find_by_id($session->user_id->id)->permissions) {
                                if ($admin_page == $menu_item->id) {
                                    echo "<li class=\"active\"><a href=\"{$menu_item->href}\"><i class=\"fa fa-{$menu_item->icon} fa-fw\"></i>&nbsp;{$menu_item->title} <span class=\"sr-only\">(current)</span></a></li>" . PHP_EOL;
                                } else {
                                    echo "<li><a href=\"{$menu_item->href}\"><i class=\"fa fa-{$menu_item->icon} fa-fw\"></i>&nbsp;{$menu_item->title}</a></li>" . PHP_EOL;
                                }
                            }
                        }
                        if (Admin_Menu::find_group_permissions($i) <= User::find_by_id($session->user_id->id)->permissions){
                            echo "</ul>" . PHP_EOL;
                        }
                    }
                    ?>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">