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
          ['Category', 'Bad', 'Good'],
          ['Bus',  {{$arr_bus[0]}},      {{$arr_bus[1]}}],
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
