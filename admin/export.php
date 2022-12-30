<?php
$admin_page=0;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");

if (filter_input(INPUT_GET, 'action')) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=export.csv');

    $output = fopen('php://output', 'w');

    switch (filter_input(INPUT_GET, 'action')) {
        case '1':
            fputcsv($output, Request::get_db_fields());
            $rows = $database->query("SELECT * FROM requests WHERE fulfillment_status=0");
            while ($row = mysqli_fetch_assoc($rows)) {
                fputcsv($output, $row);
            }
            break;
        case '2':
            fputcsv($output, Request::get_db_fields());
            $rows = $database->query("SELECT * FROM requests");
            while ($row = mysqli_fetch_assoc($rows)) {
                fputcsv($output, $row);
            }
            break;
        case '3':
            fputcsv($output, Contact::get_db_fields());
            $rows = $database->query("SELECT * FROM contacts");
            while ($row = mysqli_fetch_assoc($rows)) {
                fputcsv($output, $row);
            }
            break;
        default:
            fputcsv($output, array("Bad Request: The export could not be completed. Please go back and try again."));
    }
} else {
    require_once(LAYOUT_PATH . DS . "admin_header.php");
    echo output_message("danger|Bad Request. The export could not be completed. Please go back and try again.");
    require_once(LAYOUT_PATH . DS . "admin_footer.php");
}