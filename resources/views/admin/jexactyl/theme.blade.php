@extends('layouts.admin')
@include('partials/admin.jexactyl.nav', ['activeTab' => 'theme'])

@section('title')
    Theme Settings
@endsection

@section('content-header')
    <h1>hPanel Appearance<small>Configure the theme for hPanel.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">hPanel</li>
    </ol>
@endsection

@section('content')
    @yield('jexactyl::nav')
    <div class="row">
        <div class="col-xs-12">
            <form action="{{ route('admin.jexactyl.theme') }}" method="POST">
                <div class="box box-info
                ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Admin Themes <small>The selection for hPanel's theme.</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Admin Theme</label>
                                <div>
                                    <select name="theme:admin" class="form-control">
                                        <option @if ($admin == 'jexactyl') selected @endif value="jexactyl">hUI v3</option>
                                    </select>
                                    <p class="text-muted"><small>Determines the theme for hPanel's Admin UI.</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! csrf_field() !!}
                <button type="submit" name="_method" value="PATCH" class="btn btn-default pull-right">Save Changes</button>
            </form>
        </div>
    </div>
@endsection
