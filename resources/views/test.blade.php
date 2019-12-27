@extends('layouts.app')

@section('content')
<?php $result = ""; ?>
<div id="chart_div" style="width: 80%; height: 630px; float: left; overflow: auto;">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);
        function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
        ['Category', 'Good', 'Bad'],
                @if ($arr_bus[2] > 0)
        ['Bus', {{$arr_bus[0]}}, {{$arr_bus[1]}}],
<?php $result = $result . "Bus," . $arr_bus[0] . "," . $arr_bus[1] . "|" ?>
        @endif
                @if ($arr_wifi[2] > 0)
        ['Wifi', {{$arr_wifi[0]}}, {{$arr_wifi[1]}}],
<?php $result = $result . "Wifi," . $arr_wifi[0] . "," . $arr_wifi[1] . "|" ?>
        @endif
                @if ($arr_adminService[2] > 0)
        ['Admin Services', {{$arr_adminService[0]}}, {{$arr_adminService[1]}}],
<?php $result = $result . "Admin Services," . $arr_adminService[0] . "," . $arr_adminService[1] . "|" ?>
        @endif
                @if ($arr_food[2] > 0)
        ['Food', {{$arr_food[0]}}, {{$arr_food[1]}}],
<?php $result = $result . "Food," . $arr_food[0] . "," . $arr_food[1] . "|" ?>
        @endif
                @if ($arr_parking[2] > 0)
        ['Parking', {{$arr_parking[0]}}, {{$arr_parking[1]}}],
<?php $result = $result . "Parking," . $arr_parking[0] . "," . $arr_parking[1] . "|" ?>
        @endif
                @if ($arr_timeTable[2] > 0)
        ['Time Table', {{$arr_timeTable[0]}}, {{$arr_timeTable[1]}}],
<?php $result = $result . "Time Table," . $arr_timeTable[0] . "," . $arr_timeTable[1] . "|" ?>
        @endif
                @if ($arr_lecturer[2] > 0)
        ['Lecturer', {{$arr_lecturer[0]}}, {{$arr_lecturer[1]}}],
<?php $result = $result . "Lecturer," . $arr_lecturer[0] . "," . $arr_lecturer[1] . "|" ?>
        @endif
                @if ($arr_outdoor[2] > 0)
        ['Outdoor', {{$arr_outdoor[0]}}, {{$arr_outdoor[1]}}],
<?php $result = $result . "Outdoor," . $arr_outdoor[0] . "," . $arr_outdoor[1] . "|" ?>
        @endif
                @if ($arr_facility[2] > 0)
        ['Facility', {{$arr_facility[0]}}, {{$arr_facility[1]}}],
<?php $result = $result . "Facility," . $arr_facility[0] . "," . $arr_facility[1] . "|" ?>
        @endif
        ]);
        var options = {
        title : "TARUC Sentiment Analysis on {{ date('Y-m-d H:i') }}",
                vAxis: {title: 'Total Comments'},
                hAxis: {title: 'Category'},
                seriesType: 'bars',
                series: {2: {type: 'line'}},
                colors: ['#80FF00', 'FF0000']
        };
        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        }
    </script>
</div>

<div style="width: 20%; height: 600px; border: 1px black solid; float: right; background-color: #343a40; overflow-y: auto;">
    <?php $i = 1; ?>
    <h3 align="center" style="color: white">Issue Ranking</h3>    
    <table class="table-dark" style="width:100%;">
        <tr>
            <th>Ranking No.</th>
            <th>Category</th> 
            <th>Total</th>
            <th>Percentage</th>
        </tr>
        @foreach ($categoryBad as $key => $value)
        <?php
        $percent = number_format((float) $value / array_sum($categoryBad) * 100, 2, '.', '');
        ?>
        <tr>
            <td style="padding: 8px;">{{$i}}.</td>
            <td style="padding: 8px;">{{$key}}</td>
            <td style="padding: 8px;">{{$value}}</td>
            <td style="padding: 8px;">{{$percent}}%</td>
        </tr>
        <?php $i += 1; ?>
        @endforeach
    </table>        
</div>
<form method="post" action="">
    <input type="text" id="result" name="result" value="{{$result}}" style="display: none"/>
    <input type="submit" name="submit" value="Save to Database ?" style="position: absolute; right: 0; bottom: 0; width: 20%; height: 40px;">
</form>
@endsection
