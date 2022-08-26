@extends('layouts.admin')
@include('partials/admin.jexactyl.nav', ['activeTab' => 'index'])

@section('title')
    hPanel Settings
@endsection

@section('content-header')
    <h1>hPanel Settings<small>Configure general settings for hPanel.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Jexactyl</li>
    </ol>
@endsection

@section('content')
    @yield('jexactyl::nav')
    <div class="row">
        <div class="col-xs-12">
            <div class="box
                @if($version->isLatestPanel())
                    box-success
                @else
                    box-danger
                @endif
            ">
                <div class="box-header with-border">
                    <i class="fa fa-code-fork"></i> <h3 class="box-title">hPanel Version <small>Verify hPanel is up-to-date.</small></h3>
                </div>
                <div class="box-body">
                       You are running hPanel ={{ config('app.version') }}. 
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/chartjs/chart.min.js') !!}
    {!! Theme::js('js/admin/statistics.js') !!}
@endsection
