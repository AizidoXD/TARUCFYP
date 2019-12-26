@extends('layouts.app')

@section('content')
<div id="chart_div" style="width: 100%; height: 700px;">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Category', 'Good', 'Bad'],
          @if($arr_bus[2] > 0)
          ['Bus', {{$arr_bus[0]}}, {{$arr_bus[1]}}],
          @endif
          @if($arr_wifi[2] > 0)
          ['Wifi', {{$arr_wifi[0]}}, {{$arr_wifi[1]}}],
          @endif
          @if($arr_adminService[2] > 0)
          ['Admin Services', {{$arr_adminService[0]}}, {{$arr_adminService[1]}}],
          @endif
          @if($arr_food[2] > 0)
          ['Food', {{$arr_food[0]}}, {{$arr_food[1]}}],
          @endif
          @if($arr_parking[2] > 0)
          ['Parking', {{$arr_parking[0]}}, {{$arr_parking[1]}}],
          @endif
          @if($arr_timeTable[2] > 0)
          ['Time Table', {{$arr_timeTable[0]}}, {{$arr_timeTable[1]}}],
          @endif
          @if($arr_lecturer[2] > 0)
          ['Lecturer', {{$arr_lecturer[0]}}, {{$arr_lecturer[1]}}],
          @endif
          @if($arr_outdoor[2] > 0)
          ['Outdoor', {{$arr_outdoor[0]}}, {{$arr_outdoor[1]}}],
          @endif
          @if($arr_facility[2] > 0)
          ['Facility', {{$arr_facility[0]}}, {{$arr_facility[1]}}],
          @endif
        ]);

        var options = {
          title : 'TARUC Sentiment Analysis on xx/xx/xxxx',
          vAxis: {title: 'Total Comments'},
          hAxis: {title: 'Category'},
          seriesType: 'bars',
          series: {2: {type: 'line'}},    
		  colors: ['#80FF00','FF0000']
		  };
			
        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
</div>

<div style="width: 500px; height: 500px; border: 1px black solid">
    <h5>Issue Ranking</h5>
    Bus - 1</br>
    Wifi - 2</br>
    Parking - 3</br>
</div>
@endsection
