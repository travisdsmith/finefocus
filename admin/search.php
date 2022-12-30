<?php
$admin_page = 0;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

$search_string = filter_input(INPUT_GET, 'search');

require_once(LAYOUT_PATH . DS . "admin_header.php");
?>
<h1 class="page-header"><i class="fa fa-search fa-fw"></i>&nbsp;Search</h1>
<?= output_message($message) ?>

<p class="lead">Searching for: "<?= $search_string ?>"</p>

<?php
if (User::find_by_id($session->user_id->id)->permissions >= Admin_Menu::find_by_id(2)->permissions) {
    echo "<h2><i class=\"fa fa-pencil-square-o fa-fw\"></i>&nbsp;Requests</h2>";
    $requests = Request::search($search_string);
    if ($requests) {
        echo "<p class=\"text-muted\">Total Count: " . count($requests) . "</p>";
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
    } else {
        echo "<p class=\"text-muted\">No requests found.</p>";
    }
}
?>

<?php
if (User::find_by_id($session->user_id->id)->permissions >= Admin_Menu::find_by_id(3)->permissions) {
    echo "<h2><i class=\"fa fa-book fa-fw\"></i>&nbsp;Journals</h2>";
    $journals = Journal::search($search_string);
    if ($journals) {
        echo "<p class=\"text-muted\">Total Count: " . count($journals) . "</p>";
        echo "<div class=\"table-responsive\">" . PHP_EOL;
        echo "<table class=\"table table-striped\">" . PHP_EOL;
        echo "<thead>" . PHP_EOL;
        echo "<tr>" . PHP_EOL;
        echo "<th>Name</th>" . PHP_EOL;
        echo "<th>Release Date</th>" . PHP_EOL;
        echo "<th></th>" . PHP_EOL;
        echo "</tr>" . PHP_EOL;
        echo "</thead>" . PHP_EOL;
        echo "<tbody>" . PHP_EOL;
        foreach ($journals as $journal) {
            echo "<tr>" . PHP_EOL;
            echo "<td>" . $journal->name . "</td>" . PHP_EOL;
            echo "<td>" . date("m/d/Y", strtotime($journal->release_date)) . "</td>" . PHP_EOL;
            echo "<td>" . PHP_EOL;
            echo "<div style=\"white-space:nowrap;text-align:right;\">";
            echo "<a class=\"btn btn-primary btn-xs\" href=\"journal_edit.php?id={$journal->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>";
            echo "&nbsp;";
            echo "<a class=\"btn btn-danger btn-xs\" href=\"journal_delete.php?id={$journal->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete\"><i class=\"fa fa-trash\"></i></a>";
            echo "</div>";
            echo "</td>" . PHP_EOL;
            echo "</tr>" . PHP_EOL;
        }
        echo "</tbody>" . PHP_EOL;
        echo "</table>" . PHP_EOL;
        echo "</div>" . PHP_EOL;
    } else {
        echo "<p class=\"text-muted\">No journals found.</p>";
    }
}
?>

<?php
if (User::find_by_id($session->user_id->id)->permissions >= Admin_Menu::find_by_id(4)->permissions) {
    echo "<h2><i class=\"fa fa-files-o fa-fw\"></i>&nbsp;Pages</h2>" . PHP_EOL;
    $pages = Page::search($search_string);
    if ($pages) {
        echo "<p class=\"text-muted\">Total Count: " . count($pages) . "</p>";
        echo "<div class=\"table-responsive\">" . PHP_EOL;
        echo "<table class=\"table table-striped\">" . PHP_EOL;
        echo "<thead>" . PHP_EOL;
        echo "<tr>" . PHP_EOL;
        echo "<th>Title</th>" . PHP_EOL;
        echo "<th>Slug</th>" . PHP_EOL;
        echo "<th>Preview</th>" . PHP_EOL;
        echo "<th></th>" . PHP_EOL;
        echo "</tr>" . PHP_EOL;
        echo "</thead>" . PHP_EOL;
        echo "<tbody>" . PHP_EOL;
        foreach ($pages as $page) {
            echo "<tr>" . PHP_EOL;
            echo "<td>" . $page->title . "</td>" . PHP_EOL;
            echo "<td>" . $page->slug . "</td>" . PHP_EOL;
            echo "<td>" . $page->preview() . "</td>" . PHP_EOL;
            echo "<td>" . PHP_EOL;
            echo "<div style=\"white-space:nowrap;text-align:right;\">";
            echo "<a class=\"btn btn-primary btn-xs\" href=\"page_edit.php?id={$page->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>";
            echo "&nbsp;";
            echo "<a class=\"btn btn-danger btn-xs\" href=\"page_delete.php?id={$page->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete\"><i class=\"fa fa-trash\"></i></a>";
            echo "</div>";
            echo "</td>" . PHP_EOL;
            echo "</tr>" . PHP_EOL;
        }
        echo "</tbody>" . PHP_EOL;
        echo "</table>" . PHP_EOL;
        echo "</div>" . PHP_EOL;
    } else {
        echo "<p class=\"text-muted\">No pages found.</p>";
    }
}
?>

<?php
if (User::find_by_id($session->user_id->id)->permissions >= Admin_Menu::find_by_id(6)->permissions) {
    echo "<h2><i class=\"fa fa-university fa-fw\"></i>&nbsp;Experts</h2>" . PHP_EOL;
    $experts = Expert::search($search_string);
    if ($experts) {
        echo "<p class=\"text-muted\">Total Count: " . count($experts) . "</p>";
        echo "<div class=\"table-responsive\">" . PHP_EOL;
        echo "<table class=\"table table-striped\">" . PHP_EOL;
        echo "<thead>" . PHP_EOL;
        echo "<tr>" . PHP_EOL;
        echo "<th>Name</th>" . PHP_EOL;
        echo "<th>Institution</th>" . PHP_EOL;
        echo "<th></th>" . PHP_EOL;
        echo "</tr>" . PHP_EOL;
        echo "</thead>" . PHP_EOL;
        echo "<tbody>" . PHP_EOL;
        foreach ($experts as $expert) {
            echo "<tr>" . PHP_EOL;
            echo "<td>" . $expert->name . "</td>" . PHP_EOL;
            echo "<td>" . $expert->institution . "</td>" . PHP_EOL;
            echo "<td>" . PHP_EOL;
            echo "<div style=\"white-space:nowrap;text-align:right;\">";
            echo "<a class=\"btn btn-primary btn-xs\" href=\"expert_edit.php?id={$expert->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>";
            echo "&nbsp;";
            echo "<a class=\"btn btn-danger btn-xs\" href=\"expert_delete.php?id={$expert->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete\"><i class=\"fa fa-trash\"></i></a>";
            echo "</div>";
            echo "</td>" . PHP_EOL;
            echo "</tr>" . PHP_EOL;
        }
        echo "</tbody>" . PHP_EOL;
        echo "</table>" . PHP_EOL;
        echo "</div>" . PHP_EOL;
    } else {
        echo "<p class=\"text-muted\">No experts found.</p>";
    }
}
?>

<?php
if (User::find_by_id($session->user_id->id)->permissions >= Admin_Menu::find_by_id(7)->permissions) {
    echo "<h2><i class=\"fa fa-envelope fa-fw\"></i>&nbsp;Contacts</h2>" . PHP_EOL;
    $contacts = Contact::search($search_string);
    if ($contacts) {
        echo "<p class=\"lead\">Total Count: " . count($contacts) . "</p>";
        echo "<div class=\"table-responsive\">" . PHP_EOL;
        echo "<table class=\"table table-striped\">" . PHP_EOL;
        echo "<thead>" . PHP_EOL;
        echo "<tr>" . PHP_EOL;
        echo "<th>Name</th>" . PHP_EOL;
        echo "<th></th>" . PHP_EOL;
        echo "</tr>" . PHP_EOL;
        echo "</thead>" . PHP_EOL;
        echo "<tbody>" . PHP_EOL;
        foreach ($contacts as $contact) {
            echo "<tr>" . PHP_EOL;
            echo "<td>" . $contact->name . "</td>" . PHP_EOL;
            echo "<td>" . PHP_EOL;
            echo "<div style=\"white-space:nowrap;text-align:right;\">";
            echo "<a class=\"btn btn-primary btn-xs\" href=\"contact_edit.php?id={$contact->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>";
            echo "&nbsp;";
            echo "<a class=\"btn btn-danger btn-xs\" href=\"contact_delete.php?id={$contact->id}\" role=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete\"><i class=\"fa fa-trash\"></i></a>";
            echo "</div>";
            echo "</td>" . PHP_EOL;
            echo "</tr>" . PHP_EOL;
        }
        echo "</tbody>" . PHP_EOL;
        echo "</table>" . PHP_EOL;
        echo "</div>" . PHP_EOL;
    } else {
        echo "<p class=\"text-muted\">No contacts found.</p>";
    }
}
?>

<?php
if (User::find_by_id($session->user_id->id)->permissions >= Admin_Menu::find_by_id(8)->permissions) {
    echo "<h2><i class=\"fa fa-picture-o fa-fw\"></i>&nbsp;Pictures</h2>" . PHP_EOL;
    $media = Media::search($search_string);
    if ($media) {
        echo "<p class=\"lead\">Total Count: " . count($media) . "</p>";
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
    } else {
        echo "<p class=\"text-muted\">No pictures found.</p>";
    }
}
?>

<?php
require_once(LAYOUT_PATH . DS . "admin_footer.php");
