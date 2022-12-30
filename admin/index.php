<?php
$admin_page = 1;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");
require_once(LAYOUT_PATH . DS . "admin_header.php");

$months = ceil(date_diff(date_create(Request::first_request_date()), date_create())->format('%a')/30);
?>
<h1 class="page-header"><i class="fa fa-tachometer fa-fw"></i>&nbsp;Dashboard</h1>
<?=output_message($message)?>
<div class="visible-xs">
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        It looks like you're on a device with a small screen. The administrative sidebar that you're used to is located in the navigation bar.
    </div>
</div>
<div class="row placeholders">
    <div class="col-xs-12 col-sm-4 placeholder">
        <h1><?= Request::count_by_fulfillment_status(0) ?></h1>
        <h4>Requests to Fulfill</h4>
    </div>
    <div class="col-xs-12 col-sm-4 placeholder">
        <h1><?= Expert::count_all() ?></h1>
        <h4>Experts</h4>
    </div>
    <div class="col-xs-12 col-sm-4 placeholder">
        <h1><?= Request::average_turnaround() ?> Day<?= Request::average_turnaround() != 1 ? "s" : "" ?></h1>
        <h4>Average Turnaround</h4>
    </div>
</div>
<h2>Journal Request Information</h2>
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <h3>Requests by Type</h3>
        <p>Showing data from all dates.</p>
        <canvas id="request_type"></canvas>
        <div id="js-legend"></div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <h3>Fulfillment Status</h3>
        <p>Showing data from all dates.</p>
        <canvas id="fulfillment_status"></canvas>
    </div>
    <div class="col-md-12">
        <h3>Requests by Fulfillment Status</h3>
        <p>Showing data from the previous 18 months.</p>
        <canvas id="number_requests"></canvas>
    </div>
    <div class="col-md-12">
        <h3>Requests by Type</h3>
        <p>Showing data from the previous <?=$months?> months.</p>
        <canvas id="number_requests_type"></canvas>
    </div>
    <div class="col-md-12">
        <h3>Requests by Journal</h3>
        <p>Showing data from the previous <?=$months?> months.</p>
        <canvas id="number_requests_journal"></canvas>
    </div>
    <div class="col-md-12">
        <h3>Requests by Journal</h3>
        <p>Showing data from all dates.</p>
        <canvas id="requested_journal"></canvas>
    </div>
    <div class="col-md-12">
        <h3>Requests by Country</h3>
        <p>Showing data from all dates.</p>
        <canvas id="country_journal"></canvas>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Requests</th>
                        <th>% of Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $country_counts = Request::find_by_sql("SELECT country, COUNT(*) AS name, (COUNT(*)/(SELECT COUNT(*) FROM " . Request::get_table_name() . "))*100 AS notes FROM " . Request::get_table_name() . " GROUP BY country ORDER BY name DESC;");
                    foreach ($country_counts AS $country_count) {
                        echo "<tr>" . PHP_EOL;
                        echo "<td>" . Country::find_by_id($country_count->country)->name . "</td>" . PHP_EOL;
                        echo "<td>" . $country_count->name . "</td>" . PHP_EOL;
                        echo "<td>" . $country_count->notes . "%</td>" . PHP_EOL;
                        echo "</tr>" . PHP_EOL;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--Highlight is color + 0x141414-->
<script>
    //Fulfillment Status Pie Chart
    var fulfillmentStatusData = [
        {
            value: <?= Request::count_by_fulfillment_status(-1) ?>,
            color: "#d9534f",
            highlight: "#ed6763",
            label: "Rejected"
        },
        {
            value: <?= Request::count_by_fulfillment_status(1) ?>,
            color: "#5cb85c",
            highlight: "#70cc70",
            label: "Fulfilled"
        },
        {
            value: <?= Request::count_by_fulfillment_status(0) ?>,
            color: "#337ab7",
            highlight: "#478ecb",
            label: "Unfulfilled"
        }

    ];
    function fulfillmentStatus() {
        var ctxFS = document.getElementById("fulfillment_status").getContext("2d");
        window.pieFulfillmentStatus = new Chart(ctxFS).Pie(fulfillmentStatusData, {
            responsive: true,
            animation: false
        });
    }
    ;
    //Request Type Pie Chart
    var requestTypeData = [
        {
            value: <?= Request::count_by_request_type("o") ?>,
            color: "#5bc0de",
            highlight: "#6fd4f2",
            label: "Organizational"
        },
        {
            value: <?= Request::count_by_request_type("p") ?>,
            color: "#f0ad4e",
            highlight: "#f8c162",
            label: "Personal"
        }

    ];
    function requestType() {
        var ctxRT = document.getElementById("request_type").getContext("2d");
        window.pieRequestType = new Chart(ctxRT).Pie(requestTypeData, {
            responsive: true,
            animation: false
        });
    }
    ;
    //Number of Requests by Fulfillment Status Line Chart
    var requestsByFulfillmentData = {
        labels: ["<?php
                    $date = new DateTime("now");
                    $interval = new DateInterval('P' . $months . 'M');
                    $date->sub($interval);
                    $interval = new DateInterval('P1M');
                    for ($i = $months - 1; $i >= 0; $i--) {
                        $date->add($interval);
                        echo $date->format('M Y');
                        echo $i != 0 ? '","' : '';
                    }
                    ?>"],
        datasets: [
            {
                label: "Journals Requested",
                fillColor: "rgba(51, 122, 183,0.2)",
                strokeColor: "rgba(51, 122, 183,1)",
                pointColor: "rgba(51, 122, 183,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(51, 122, 183,1)",
                data: [<?php
                    for ($i = $months - 1; $i >= 0; $i--) {
                        $request_count = mysqli_fetch_row($db->query("SELECT COUNT(*) FROM " . Request::get_table_name() . " WHERE PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM CURDATE()), EXTRACT(YEAR_MONTH FROM request_date))=" . $i));
                        echo $request_count[0];
                        echo $i != 0 ? ',' : '';
                    }
                    ?>]
            },
            {
                label: "Requests Fulfilled",
                fillColor: "rgba(92, 184, 92,0.2)",
                strokeColor: "rgba(92, 184, 92,1)",
                pointColor: "rgba(92, 184, 92,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(92, 184, 92,1)",
                data: [<?php
                    for ($i = $months - 1; $i >= 0; $i--) {
                        $fulfill_count = mysqli_fetch_row($db->query("SELECT COUNT(*) FROM " . Request::get_table_name() . " WHERE fulfillment_status=1 AND PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM CURDATE()), EXTRACT(YEAR_MONTH FROM fulfillment_date))=" . $i));
                        echo $fulfill_count[0];
                        echo $i != 0 ? ',' : '';
                    }
                    ?>]
            },
            {
                label: "Requests Rejected",
                fillColor: "rgba(217, 83, 79,0.2)",
                strokeColor: "rgba(217, 83, 79,1)",
                pointColor: "rgba(217, 83, 79,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(217, 83, 79,1)",
                data: [<?php
                    for ($i = $months - 1; $i >= 0; $i--) {
                        $fulfill_count = mysqli_fetch_row($db->query("SELECT COUNT(*) FROM " . Request::get_table_name() . " WHERE fulfillment_status=-1 AND PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM CURDATE()), EXTRACT(YEAR_MONTH FROM fulfillment_date))=" . $i));
                        echo $fulfill_count[0];
                        echo $i != 0 ? ',' : '';
                    }
                    ?>]
            }
        ]

    }

    var requestsByFulfillment = function () {
        var ctxRF = document.getElementById("number_requests").getContext("2d");
        window.lineRequestsByFulfillment = new Chart(ctxRF).Line(requestsByFulfillmentData, {
            responsive: true,
            animation: false
        });
    }


    //Number of Requests by Fulfillment Status Line Chart
    var requestsByTypeData = {
        labels: ["<?php
                    $date = new DateTime("now");
                    $interval = new DateInterval('P' . $months . 'M');
                    $date->sub($interval);
                    $interval = new DateInterval('P1M');
                    for ($i = $months - 1; $i >= 0; $i--) {
                        $date->add($interval);
                        echo $date->format('M Y');
                        echo $i != 0 ? '","' : '';
                    }
                    ?>"],
        datasets: [
            {
                label: "Organizational",
                fillColor: "rgba(91, 192, 222,0.2)",
                strokeColor: "rgba(91, 192, 222,1)",
                pointColor: "rgba(91, 192, 222,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(91, 192, 222,1)",
                data: [<?php
                    for ($i = $months - 1; $i >= 0; $i--) {
                        $request_count = mysqli_fetch_row($db->query("SELECT COUNT(*) FROM " . Request::get_table_name() . " WHERE request_type='o' AND PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM CURDATE()), EXTRACT(YEAR_MONTH FROM request_date))=" . $i));
                        echo $request_count[0];
                        echo $i != 0 ? ',' : '';
                    }
                    ?>]
            },
            {
                label: "Personal",
                fillColor: "rgba(240, 173, 78,0.2)",
                strokeColor: "rgba(240, 173, 78,1)",
                pointColor: "rgba(240, 173, 78,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(240, 173, 78,1)",
                data: [<?php
                    for ($i = $months - 1; $i >= 0; $i--) {
                        $fulfill_count = mysqli_fetch_row($db->query("SELECT COUNT(*) FROM " . Request::get_table_name() . " WHERE request_type='p' AND PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM CURDATE()), EXTRACT(YEAR_MONTH FROM request_date))=" . $i));
                        echo $fulfill_count[0];
                        echo $i != 0 ? ',' : '';
                    }
                    ?>]
            }
        ]

    }

    var requestsByType = function () {
        var ctxRT = document.getElementById("number_requests_type").getContext("2d");
        window.lineRequestsByType = new Chart(ctxRT).Line(requestsByTypeData, {
            responsive: true,
            animation: false
        });
    }
    
    //Requests by Journal Volume
    var requestsByJournalData = {
        labels: ["<?php
                    $date = new DateTime("now");
                    $interval = new DateInterval('P' . $months . 'M');
                    $date->sub($interval);
                    $interval = new DateInterval('P1M');
                    for ($i = $months - 1; $i >= 0; $i--) {
                        $date->add($interval);
                        echo $date->format('M Y');
                        echo $i != 0 ? '","' : '';
                    }
                    ?>"],
        datasets: [
<?php
$journals = Journal::find_all();
$color = 0;
foreach ($journals as $journal) {
    echo "{" . PHP_EOL;
    echo "label: \"{$journal->name}\"," . PHP_EOL;
    echo "fillColor: \"rgba(" . color_scheme($color%20) . ",0.2)\"," . PHP_EOL;
    echo "strokeColor: \"rgba(" . color_scheme($color%20) . ",1)\"," . PHP_EOL;
    echo "pointColor: \"rgba(" . color_scheme($color%20) . ",1)\"," . PHP_EOL;
    echo "pointStrokeColor: \"#fff\"," . PHP_EOL;
    echo "pointHighlightFill: \"#fff\"," . PHP_EOL;
    echo "pointHighlightStroke: \"rgba(" . color_scheme($color%20) . ",1)\"," . PHP_EOL;
    echo "data: [" . PHP_EOL;
    for ($i = $months - 1; $i >= 0; $i--) {
        $count = mysqli_fetch_row($db->query("SELECT COUNT(*) FROM " . Request::get_table_name() . " WHERE requested_journal={$journal->id} AND PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM CURDATE()), EXTRACT(YEAR_MONTH FROM request_date))=" . $i));
        echo $count[0];
        echo $i != 0 ? ',' : '';
    }
    echo "]" . PHP_EOL;
    echo "}," . PHP_EOL;
    $color++;
}
?>
        ]
    }

    var requestsByJournal = function () {
        var ctxRJ = document.getElementById("number_requests_journal").getContext("2d");
        window.lineRequestsByJournal = new Chart(ctxRJ).Line(requestsByJournalData, {
            responsive: true,
            animation: false
        });
    }
    
    //Journal Volume Pie Chart
    var requestsJournalsData = [
    <?php
$journals = Journal::find_all();
$color = 0;
foreach ($journals as $journal) {
    echo "{" . PHP_EOL;
    echo "value: " . mysqli_fetch_row($db->query("SELECT COUNT(*) FROM " . Request::get_table_name() . " WHERE requested_journal={$journal->id}"))[0] . "," . PHP_EOL;
    echo "color: \"rgba(" . color_scheme($color%20) . ",1)\"," . PHP_EOL;
    echo "highlight: \"rgba(" . color_scheme($color%20) . ",.7)\"," . PHP_EOL;
    echo "label: \"" . $journal->name . "\"" . PHP_EOL;
    echo "}," . PHP_EOL;
    $color++;
}
?>

    ];
    function requestsJournals() {
        var ctxRS = document.getElementById("requested_journal").getContext("2d");
        window.pieRequestsJournals = new Chart(ctxRS).Pie(requestsJournalsData, {
            responsive: true,
            animation: false
        });
    }
    ;
    
    //Country Volume Pie Chart
    var requestsCountryData = [
    <?php
$country_counts = Request::find_by_sql("SELECT country, COUNT(*) AS name FROM " . Request::get_table_name() . " GROUP BY country;");
$color = 9;
foreach ($country_counts as $country_count) {
    echo "{" . PHP_EOL;
    echo "value: " . $country_count->name . "," . PHP_EOL;
    echo "color: \"rgba(" . color_scheme($color%20) . ",1)\"," . PHP_EOL;
    echo "highlight: \"rgba(" . color_scheme($color%20) . ",.7)\"," . PHP_EOL;
    echo "label: \"" . Country::find_by_id($country_count->country)->name . "\"" . PHP_EOL;
    echo "}," . PHP_EOL;
    $color++;
}
?>

    ];
    function requestsCountry() {
        var ctxRC = document.getElementById("country_journal").getContext("2d");
        window.pieCountryJournals = new Chart(ctxRC).Pie(requestsCountryData, {
            responsive: true,
            animation: false
        });
    }
    ;

    //Load all graphs on the page
    function start() {
        fulfillmentStatus();
        requestType();
        requestsByFulfillment();
        requestsByType();
        requestsByJournal();
        requestsJournals();
        requestsCountry();
    }
    window.onload = start;
</script>
<?php
require_once(LAYOUT_PATH . DS . "admin_footer.php");
