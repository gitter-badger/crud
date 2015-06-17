@extends('crud::master')

@section('subheader')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{trans('crud::views.dashboard.title')}}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
@stop

@section('content')
    <div class="jumbotron">
        <div class="container-fluid">
            <h1>Welcome to the BlackfyreStudio/CRUD admin generator!</h1>
            <p>To change this, edit the published template file under <code>resources/views/vendor/crud/layouts/dashboard.blade.php</code></p>
        </div>
    </div>
@stop