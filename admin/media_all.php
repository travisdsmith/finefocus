<?php
$admin_page = 8;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");
require_once(LAYOUT_PATH . DS . "admin_header.php")
?>
<h1 class="page-header"><i class="fa fa-picture-o fa-fw"></i>&nbsp;Media Library&nbsp;<a class="btn btn-default" href="media_add.php" role="button" data-toggle="tooltip" data-placement="top" title="Add"><i class="fa fa-plus fa-fw"></i></a></h1>
        <?= output_message($message) ?>

<?php
$page = !empty(filter_input(INPUT_GET, 'page')) ? (int) filter_input(INPUT_GET, 'page') : 1;
$per_page = 20;
$total_count = Media::count_all();
$pagination = new Pagination($page, $per_page, $total_count);
$media = Media::find_by_sql("SELECT * FROM " . Media::get_table_name() . " LIMIT {$per_page} OFFSET {$pagination->offset()}");


if ($media) {
    echo "<p class=\"lead\">Total Count: " . $total_count . "</p>";
    echo "<div class=\"table-responsive\">" . PHP_EOL;
    echo "<table class=\"table table-striped\">" . PHP_EOL;
    echo "<thead>" . PHP_EOL;
    echo "<tr>" . PHP_EOL;
    echo "<th>Preview (click to view larger)</th>" . PHP_EOL;
    echo "<th>Source Link</th>" . PHP_EOL;
    echo "<th>Type</th>" . PHP_EOL;
    echo "<th>Size</th>" . PHP_EOL;
    echo "<th>Description</th>" . PHP_EOL;
    echo "<th></th>" . PHP_EOL;
    echo "</tr>" . PHP_EOL;
    echo "</thead>" . PHP_EOL;
    echo "<tbody>" . PHP_EOL;
    foreach ($media as $medium) {
        echo "<tr>" . PHP_EOL;
        echo "<td><a href=\"../{$medium->image_path()}\" target=\"_blank\"><img src=\"../{$medium->image_path()}\" width=\"200\" alt=\"Preview not available.\"/></a></td>" . PHP_EOL;
        echo "<td>";
        echo "<div style=\"white-space:nowrap;\">";
        echo "<input type=\"text\" id=\"url" . $medium->id . "\" onClick=\"this.setSelectionRange(0, this.value.length)\" value=\"" . BASE_URL . $medium->image_path() . "\" readonly>";
        echo "&nbsp;<button class=\"copy btn btn-default btn-xs\" data-clipboard-target=\"#url" . $medium->id . "\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Copy to Clipboard\"><i class=\"fa fa-clipboard fa-fw\"></i></button>";
        echo "</div>";
        echo "</td>" . PHP_EOL;
        echo "<td>" . $medium->type . "</td>" . PHP_EOL;
        echo "<td>" . $medium->size . "</td>" . PHP_EOL;
        echo "<td>" . $medium->description . "</td>" . PHP_EOL;
        echo "<td>" . PHP_EOL;
        echo "<div style=\"white-space:nowrap;text-align:right;\">";
        echo "<a class=\"btn btn-primary btn-xs\" href=\"media_edit.php?id={$medium->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>";
        echo "&nbsp;";
        echo "<a class=\"btn btn-danger btn-xs\" href=\"media_delete.php?id={$medium->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete\"><i class=\"fa fa-trash\"></i></a>";
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
            echo "<li><a href=\"media_all.php?page=1\" aria-label=\"First Page\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
            echo "<li><a href=\"media_all.php?page={$pagination->previous_page()}\" aria-label=\"Previous\"><span aria-hidden=\"true\">&lsaquo;</span></a></li>";
        }

        if ($pagination->total_pages() > 5) {
            if ($page <= 2) {
                for ($i = 1; $i <= 5; $i++) {
                    if ($i == $page) {
                        echo "<li class=\"active\"><a href=\"media_all.php?page={$i}\"> {$i} <span class=\"sr-only\">(current)</span></a></li>";
                    } else {
                        echo "<li><a href=\"media_all.php?page={$i}\"> {$i} </a></li>";
                    }
                }
            } else if ($page >= $pagination->total_pages() - 2) {
                for ($i = $pagination->total_pages() - 4; $i <= $pagination->total_pages(); $i++) {
                    if ($i == $page) {
                        echo "<li class=\"active\"><a href=\"media_all.php?page={$i}\"> {$i} <span class=\"sr-only\">(current)</span></a></li>";
                    } else {
                        echo "<li><a href=\"media_all.php?page={$i}\"> {$i} </a></li>";
                    }
                }
            } else {
                for ($i = $page - 2; $i <= $page + 2; $i++) {
                    if ($i == $page) {
                        echo "<li class=\"active\"><a href=\"media_all.php?page={$i}\"> {$i} <span class=\"sr-only\">(current)</span></a></li>";
                    } else {
                        echo "<li><a href=\"media_all.php?page={$i}\"> {$i} </a></li>";
                    }
                }
            }
        } else {
            for ($i = 1; $i <= $pagination->total_pages(); $i++) {
                if ($i == $page) {
                    echo "<li class=\"active\"><a href=\"media_all.php?page={$i}\"> {$i} <span class=\"sr-only\">(current)</span></a></li>";
                } else {
                    echo "<li><a href=\"media_all.php?page={$i}\"> {$i} </a></li>";
                }
            }
        }

        if ($pagination->has_next_page()) {
            echo "<li><a href=\"media_all.php?page={$pagination->next_page()}\" aria-label=\"Next\"><span aria-hidden=\"true\">&rsaquo;</span></a></li>";
            echo "<li><a href=\"media_all.php?page={$pagination->total_pages()}\" aria-label=\"Last Page\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
        }
        echo "</ul></nav>" . PHP_EOL;
    }
} else {
    echo "<p class=\"text-muted\">No media found.</p>";
}
?>

<?php
require_once(LAYOUT_PATH . DS . "admin_footer.php");
