@extends('layoutBack')
    
@section('css')
    <style>
        body {
            height: 100%;
            background-color: #fff;
        }
    </style>
@stop

@section('content')
    <!-- Notifications -->
    @include('sentinel.notifications')

    <div class="row">
        <div class="col-lg-12" style="">
            <h1 class="page-header">
                Dashboard <small>Statistics Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
            </ol>
        </div>
    </div><!-- /.row -->
@stop