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
        </div>
    </div>
</div>
@endsection
