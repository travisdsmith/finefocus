<?php
$admin_page = 2;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");
require_once(LAYOUT_PATH . DS . "admin_header.php")
?>
<h1 class="page-header"><i class="fa fa-pencil-square-o fa-fw"></i>&nbsp;Requests
    &nbsp;<a class="btn btn-default<?= filter_input(INPUT_GET, "status") == "u" ? " active" : "" ?>" href="request_all.php<?= filter_input(INPUT_GET, "status") == "u" ? "" : "?status=u" ?>" role="button" data-toggle="tooltip" data-placement="top" title="Toggle Unfulfilled Requests"><i class="fa fa-filter fa-fw"></i></a>
    <a class="btn btn-default" href="export.php?action=<?= filter_input(INPUT_GET, "status") == "u" ? 1 : 2 ?>" role="button" data-toggle="tooltip" data-placement="top" title="Export to CSV"><i class="fa fa-share-square-o fa-fw"></i></a>
</h1>
<?= output_message($message) ?>
<?php
$page = !empty(filter_input(INPUT_GET, 'page')) ? (int) filter_input(INPUT_GET, 'page') : 1;
$per_page = 20;
if (filter_input(INPUT_GET, "status") == "u") {
    $total_count = Request::count_all();
    $pagination = new Pagination($page, $per_page, $total_count);
    $requests = Request::find_by_sql("SELECT * FROM " . Request::get_table_name() . " WHERE fulfillment_status=0 LIMIT {$per_page} OFFSET {$pagination->offset()}");
} else {
    $total_count = Request::count_all();
    $pagination = new Pagination($page, $per_page, $total_count);
    $requests = Request::find_by_sql("SELECT * FROM " . Request::get_table_name() . " LIMIT {$per_page} OFFSET {$pagination->offset()}");
}


if ($requests) {
    echo "<p class=\"lead\">Total Count: " . $total_count . "</p>";
    echo "<div class=\"table-responsive\">" . PHP_EOL;
    echo "<table class=\"table table-striped\">" . PHP_EOL;
    echo "<thead>" . PHP_EOL;
    echo "<tr>" . PHP_EOL;
    echo "<th>Order #</th>" . PHP_EOL;
    echo "<th>Request Date</th>" . PHP_EOL;
    echo "<th>Name</th>" . PHP_EOL;
    echo "<th>Journal</th>" . PHP_EOL;
    echo "<th>Fulfillment Date</th>" . PHP_EOL;
    echo "<th>Status</th>" . PHP_EOL;
    echo "<th></th>" . PHP_EOL;
    echo "</tr>" . PHP_EOL;
    echo "</thead>" . PHP_EOL;
    echo "<tbody>" . PHP_EOL;
    foreach ($requests as $request) {
        echo "<tr>" . PHP_EOL;
        echo "<td>" . $request->id . "</td>" . PHP_EOL;
        echo "<td>" . date("m/d/Y", strtotime($request->request_date)) . "</td>" . PHP_EOL;
        echo "<td>" . $request->name . "</td>" . PHP_EOL;
        echo "<td>" . Journal::find_by_id($request->requested_journal)->name . "</td>" . PHP_EOL;
        echo "<td>" . date("m/d/Y", strtotime($request->fulfillment_date)) . "</td>" . PHP_EOL;
        echo "<td>";
        switch ($request->fulfillment_status) {
            case 0:
                echo "<span class=\"label label-primary\">Unfulfilled</span>";
                break;
            case 1:
                echo "<span class=\"label label-success\">Fulfilled</span>";
                break;
            case -1:
                echo "<span class=\"label label-danger\">Rejected</span>";
                break;
            default:
                echo "<span class=\"label label-default\">UNKOWN</span>";
                break;
        }
        echo "</td>" . PHP_EOL;
        echo "<td>" . PHP_EOL;
        echo "<div style=\"white-space:nowrap;text-align:right;\">";
        echo "<a class=\"btn btn-primary btn-xs\" href=\"request_edit.php?id={$request->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>";
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
            echo "<li><a href=\"request_all.php?page=1\" aria-label=\"First Page\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
            echo "<li><a href=\"request_all.php?page={$pagination->previous_page()}\" aria-label=\"Previous\"><span aria-hidden=\"true\">&lsaquo;</span></a></li>";
        }

        if ($pagination->total_pages() > 5) {
            if ($page <= 2) {
                for ($i = 1; $i <= 5; $i++) {
                    if ($i == $page) {
                        echo "<li class=\"active\"><a href=\"request_all.php?page={$i}\"> {$i} <span class=\"sr-only\">(current)</span></a></li>";
                    } else {
                        echo "<li><a href=\"request_all.php?page={$i}\"> {$i} </a></li>";
                    }
                }
            } else if ($page >= $pagination->total_pages() - 2) {
                for ($i = $pagination->total_pages() - 4; $i <= $pagination->total_pages(); $i++) {
                    if ($i == $page) {
                        echo "<li class=\"active\"><a href=\"request_all.php?page={$i}\"> {$i} <span class=\"sr-only\">(current)</span></a></li>";
                    } else {
                        echo "<li><a href=\"request_all.php?page={$i}\"> {$i} </a></li>";
                    }
                }
            } else {
                for ($i = $page - 2; $i <= $page + 2; $i++) {
                    if ($i == $page) {
                        echo "<li class=\"active\"><a href=\"request_all.php?page={$i}\"> {$i} <span class=\"sr-only\">(current)</span></a></li>";
                    } else {
                        echo "<li><a href=\"request_all.php?page={$i}\"> {$i} </a></li>";
                    }
                }
            }
        } else {
            for ($i = 1; $i <= $pagination->total_pages(); $i++) {
                if ($i == $page) {
                    echo "<li class=\"active\"><a href=\"request_all.php?page={$i}\"> {$i} <span class=\"sr-only\">(current)</span></a></li>";
                } else {
                    echo "<li><a href=\"request_all.php?page={$i}\"> {$i} </a></li>";
                }
            }
        }

        if ($pagination->has_next_page()) {
            echo "<li><a href=\"request_all.php?page={$pagination->next_page()}\" aria-label=\"Next\"><span aria-hidden=\"true\">&rsaquo;</span></a></li>";
            echo "<li><a href=\"request_all.php?page={$pagination->total_pages()}\" aria-label=\"Last Page\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
        }
        echo "</ul></nav>" . PHP_EOL;
    }
} else {
    echo "<p class=\"text-muted\">No requests found.</p>";
}
?>
<?php
require_once(LAYOUT_PATH . DS . "admin_footer.php");
