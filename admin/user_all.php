<?php
$admin_page = 9;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");
require_once(LAYOUT_PATH . DS . "admin_header.php")
?>
<h1 class="page-header"><i class="fa fa-users fa-fw"></i>&nbsp;Users&nbsp;<a class="btn btn-default" href="user_edit.php" role="button" data-toggle="tooltip" data-placement="top" title="Add"><i class="fa fa-plus fa-fw"></i></a></h1>
<?= output_message($message) ?>
<?php
$page = !empty(filter_input(INPUT_GET, 'page')) ? (int) filter_input(INPUT_GET, 'page') : 1;
$per_page = 20;
$total_count = User::count_all();
$pagination = new Pagination($page, $per_page, $total_count);
$users = User::find_by_sql("SELECT * FROM " . User::get_table_name() . " LIMIT {$per_page} OFFSET {$pagination->offset()}");


if ($users) {
    echo "<p class=\"lead\">Total Count: " . $total_count . "</p>";
    echo "<div class=\"table-responsive\">" . PHP_EOL;
    echo "<table class=\"table table-striped\">" . PHP_EOL;
    echo "<thead>" . PHP_EOL;
    echo "<tr>" . PHP_EOL;
    echo "<th>Username</th>" . PHP_EOL;
    echo "<th>Type</th>" . PHP_EOL;
    echo "<th>Last Login</th>" . PHP_EOL;
    echo "<th></th>" . PHP_EOL;
    echo "</tr>" . PHP_EOL;
    echo "</thead>" . PHP_EOL;
    echo "<tbody>" . PHP_EOL;
    foreach ($users as $user) {
        echo "<tr>" . PHP_EOL;
        echo "<td>" . $user->username . "</td>" . PHP_EOL;
        echo "<td>" . $user->get_type() . "</td>" . PHP_EOL;
        echo "<td>" . ($user->last_login ? date("m/d/Y g:i:s A", strtotime($user->last_login)) : "Never") . "</td>" . PHP_EOL;
        echo "<td>" . PHP_EOL;
        echo "<div style=\"white-space:nowrap;text-align:right;\">";
        echo "<a class=\"btn btn-primary btn-xs" . ($user->permissions == 3 && User::count_primary_administrators() == 1 ? " disabled" : "") . "\" href=\"user_edit.php?id={$user->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>";
        echo "&nbsp;";
        echo "<a class=\"btn btn-danger btn-xs" . ($user->permissions == 3 && User::count_primary_administrators() == 1 ? " disabled" : "") . "\" href=\"user_delete.php?id={$user->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete\"><i class=\"fa fa-trash\"></i></a>";
        echo "</div>";
        echo "</td>" . PHP_EOL;
        echo "</tr>" . PHP_EOL;
    }
    echo "</tbody>" . PHP_EOL;
    echo "</table>" . PHP_EOL;
    echo "</div>" . PHP_EOL;


    if ($pagination->total_pages() > 1) {
        echo "<nav><ul class=\"pagination\">" . PHP_EOL;
        if ($pagination->has_previous_page()) {
            echo "<li><a href=\"user_all.php?page=1\" aria-label=\"First Page\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
            echo "<li><a href=\"user_all.php?page={$pagination->previous_page()}\" aria-label=\"Previous\"><span aria-hidden=\"true\">&lsaquo;</span></a></li>";
        }

        if ($pagination->total_pages() > 5) {
            if ($page <= 2) {
                for ($i = 1; $i <= 5; $i++) {
                    if ($i == $page) {
                        echo "<li class=\"active\"><a href=\"user_all.php?page={$i}\"> {$i} <span class=\"sr-only\">(current)</span></a></li>";
                    } else {
                        echo "<li><a href=\"user_all.php?page={$i}\"> {$i} </a></li>";
                    }
                }
            } else if ($page >= $pagination->total_pages() - 2) {
                for ($i = $pagination->total_pages() - 4; $i <= $pagination->total_pages(); $i++) {
                    if ($i == $page) {
                        echo "<li class=\"active\"><a href=\"user_all.php?page={$i}\"> {$i} <span class=\"sr-only\">(current)</span></a></li>";
                    } else {
                        echo "<li><a href=\"user_all.php?page={$i}\"> {$i} </a></li>";
                    }
                }
            } else {
                for ($i = $page - 2; $i <= $page + 2; $i++) {
                    if ($i == $page) {
                        echo "<li class=\"active\"><a href=\"user_all.php?page={$i}\"> {$i} <span class=\"sr-only\">(current)</span></a></li>";
                    } else {
                        echo "<li><a href=\"user_all.php?page={$i}\"> {$i} </a></li>";
                    }
                }
            }
        } else {
            for ($i = 1; $i <= $pagination->total_pages(); $i++) {
                if ($i == $page) {
                    echo "<li class=\"active\"><a href=\"user_all.php?page={$i}\"> {$i} <span class=\"sr-only\">(current)</span></a></li>";
                } else {
                    echo "<li><a href=\"user_all.php?page={$i}\"> {$i} </a></li>";
                }
            }
        }

        if ($pagination->has_next_page()) {
            echo "<li><a href=\"user_all.php?page={$pagination->next_page()}\" aria-label=\"Next\"><span aria-hidden=\"true\">&rsaquo;</span></a></li>";
            echo "<li><a href=\"user_all.php?page={$pagination->total_pages()}\" aria-label=\"Last Page\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
        }
        echo "</ul></nav>" . PHP_EOL;
    }
} else {
    echo "<p class=\"text-muted\">No users found.</p>";
}
?>
<?php
require_once(LAYOUT_PATH . DS . "admin_footer.php");
