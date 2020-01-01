@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Import Test Data CSV</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{url('/import_excel')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @if(session('errors'))
                        <li style="color: red">{{session('errors')}}</li>
                        @endif

                        @if(session('success'))
                        <span style="color: green">{{session('success')}}</span>
                        @endif

                        <h2>Select excel file to uploaded</h2>

                        <input type="file" name="file" id="file" required>
                        <br><br>

                        <button type="submit">Upload</button>
                        <br>
                    </form>
                </div>
            </div>

            <br>

            <div class="card">
                <form action="{{route('analyzing')}}" method="post">
                    <div class="card-header">CSV File List</div>
                    <div class="card-body">
                        <h2>Select a CSV file to run the sentiment analysis</h2>
                        <?php
                        $dir = public_path('/Excel/Test/');
                        $csvList = scandir($dir, 1);
                        ?>
                        @if(!empty($checkedBoxError))
                        <span style="color: red">{{$checkedBoxError}}</span>
                        @endif
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
                        <input type="checkbox" name="Bus" value="Bus">Bus &nbsp;
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
                    <div class="card-header">History Result</div>
                    <div class="card-body" style='overflow-y: auto;'>
                        @if(!empty($successMessage))
                        <span style="color: green">{{$successMessage}}</span>
                        @endif
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
