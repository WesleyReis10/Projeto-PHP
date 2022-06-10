@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <h1>Dashboard</h1>
@stop


@section('content')
<div class="row">
    <div class="col-12">
        @if (session()->has('create'))
            <div class="alert alert-success">
                {{ session()->get('create') }}
            </div>
        @endif
        @if (session()->has('delete'))
            <div class="alert alert-danger">
                {{ session()->get('delete') }}
            </div>
        @endif
        @if (session()->has('update'))
            <div class="alert alert-primary">
                {{ session()->get('update') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
    </div>
</div>

    <p>Welcome to this beautiful admin panel.</p>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
