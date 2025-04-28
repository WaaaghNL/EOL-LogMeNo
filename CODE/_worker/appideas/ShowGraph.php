<?php
//https://developers.google.com/chart
//https://apexcharts.com/features/
//https://canvasjs.com/php-charts/


require ('../../includes/include.php');

//$ideasADay = DB::query("SELECT DATE(created_at) AS date, COUNT(*) AS count_per_day FROM ideas GROUP BY DATE(created_at)");
$ideasADay = DB::query("SELECT DATE(`startTime`) AS date, COUNT(*) AS calls_per_day, YEAR(`startTime`) AS year FROM `ringcentral_logrows` WHERE tenantid = %i GROUP BY DATE(`startTime`) LIMIT 100", 2);

//print_r($ideasADay);

$data = array();

foreach ($ideasADay as $row) {
    $data[$row['date']] = $row['calls_per_day'];
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Testing Chart</title>

        <!-- Google charts -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {"packages": ["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn("date", "Date");
                data.addColumn("number", "Calls per dag");
                var rows = [

<?php
foreach ($data as $date => $count) {
    echo '[new Date("' . $date . '"), ' . $count . '],';
}
?>

                ];
                data.addRows(rows);
                var options = {
                    title: "Records Count per Day",
                    curveType: "function",
                    legend: {position: "bottom"}
                };
                var chart = new google.visualization.LineChart(document.getElementById("chart_div"));
                chart.draw(data, options);
            }
        </script>


    </head>

    <body>



        <div id="chart_div" style="width: 1600px; height: 600px;"></div>

        <div id="chart" style="width: 1600px; height: 600px;"></div>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </body>

</html>