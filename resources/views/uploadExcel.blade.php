@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload Test CSV file<span style="float: right"><a href="{{url('/home')}}" style="color: blue"><u>Back</u></a></span></div>

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

                        <input type="file" name="file" id="file">
                        <br><br>

                        <button type="submit">Upload</button>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
