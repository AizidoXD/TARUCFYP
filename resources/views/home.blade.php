@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <a href="{{ url('upload_excel') }}">Import Excel File.</a></br>
                    <a href="{{ url('test_ml') }}">Run Analysis</a> This should show the list of csv file
                </div>
            </div>

            <br>

            <div class="card">
                <form action="{{route('analyzing')}}" method="post">
                    <div class="card-header">CSV File List</div>
                    <div class="card-body">
                        <?php
                        $dir = public_path('/Excel/Test/');
                        $csvList = scandir($dir, 1);
                        ?>
                        <table style="width: 100%">
                            <tr>
                                <th>File Name</th>
                                <th>Select Here</th>
                            </tr>
                            @for($i = 0; $i < count($csvList) - 2; $i++)
                            <tr>
                                <td>
                                    {{$csvList[$i]}}
                                </td>
                                <td>
                                    @if($i === 0)
                                    <input type="radio" id="{{$i}}" name="csvName" value="{{$csvList[$i]}}" checked>
                                    @else
                                    <input type="radio" id="{{$i}}" name="csvName" value="{{$csvList[$i]}}">
                                    @endif
                                </td>
                            </tr>
                            @endfor
                        </table>
                        <input type="checkbox" name="Bus" value="Bus" checked required>Bus &nbsp;
                        <input type="checkbox" name="Wifi" value="Wifi">Wifi &nbsp;
                        <input type="checkbox" name="AdminService" value="AdminService">AdminService &nbsp;
                        <input type="checkbox" name="Food" value="Food">Food &nbsp;
                        <input type="checkbox" name="Parking" value="Parking">Parking &nbsp;
                        <input type="checkbox" name="TimeTable" value="TimeTable">TimeTable &nbsp;
                        <input type="checkbox" name="Lecturer" value="Lecturer">Lecturer &nbsp;
                        <input type="checkbox" name="Outdoor" value="Outdoor">Outdoor &nbsp;
                        <input type="checkbox" name="Facility" value="Facility">Facility
                        <input type="submit" value="Analyze" style="float: right"/>
                        {{csrf_field()}}
                    </div>
                </form>
            </div>

            <br>

            <div class="card">
                <?php

                use App\file;

                    $files = file::all()->toArray();
                ?>
                <form action="{{url('retrieveHistory')}}" method="post">
                    <div class="card-header">History File</div>
                    <div class="card-body">
                        <table style="width: 100%">
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>File Name</th>
                                <th>View Record</th>
                                <th></th>
                            </tr>
                            @foreach($files as $row)
                            <tr>
                                <td>{{$row['id']}}</td>
                                <td>{{$row['date']}}</td>
                                <td>{{$row['name']}}</td>
                                <?php
                                    $filePK = $row['id'];
                                ?>
                                <td><button><a href="{{url('retrieveHistory',$filePK)}}"</a>View</button></td>
                            </tr>
                            @endforeach
                        </table>
                        {{csrf_field()}}

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
