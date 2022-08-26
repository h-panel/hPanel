{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>hPanel</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="_token" content="{{ csrf_token() }}">
        <link rel="manifest" href="/favicons/manifest.json">
        <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
        <link rel="shortcut icon" href="https://cdn.discordapp.com/attachments/987734229469253674/1012679062889697330/Purple_Dark_Blue_Modern_Letter_H_Logo_Technology.png">
        <meta name="msapplication-config" content="/favicons/browserconfig.xml">
        <meta name="theme-color" content="#0e4688">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <script src="https://unpkg.com/feather-icons"></script>

        @include('layouts.scripts')

        @section('scripts')
            {!! Theme::css('vendor/select2/select2.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/bootstrap/bootstrap.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/adminlte/admin.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/adminlte/colors/skin-blue.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/sweetalert/sweetalert.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/animate/animate.min.css?t={cache-version}') !!}
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        @show
    </head>
<style>
/**
 * Pterodactyl - Panel
 * Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
@import 'checkbox.css';

body {
    color: #cad1d8;
    background-color: #272b30;
}

.skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side {
    background-color: #181f27;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,.12), 0 2px 4px 0 rgba(0,0,0,.08);
}

.skin-blue .main-header .logo {
    background-color: #363c44;
    color: #9aa5b1;
}

.skin-blue .main-header .navbar .sidebar-toggle {
    color: #9aa5b1;
}

.skin-blue .main-header .navbar .nav>li>a {
    color: #9aa5b1;
}

.skin-blue .sidebar-menu>li.header {
    color: #797979;
    background: #363c44;
}

.skin-blue .main-header .navbar {
    background-color: #363c44;
}

.skin-blue .main-header .navbar .sidebar-toggle:hover {
    background-color: #363c44;
}

.skin-blue .main-header .logo:hover {
    background-color: #363c44;
    color: #f0f0f0;
}

.main-footer {
    background: #363c44;
    color: #9aa5b1;
    border-top: 1px solid #1f2933;
}

.skin-blue .sidebar-menu>li.active>a {
    border-left-color: transparent;
    background-color: #363c44;
    color: #0069ff;
}

.skin-blue .sidebar-menu>li.hover>a {
    border-left-color: transparent;
    background-color: #363c44;
    color: #0069ff;
}


.text-gray {
    color: #9aa5b1 !important;
}

.text-green {
    color: #00a65a !important;
}

.text-muted {
    color: #9aa5b1 !important;
}

.text-danger {
    color: #ff1c00;
}

.content-wrapper {
    background-color: #272b30;
}

.btn-success {
    background-color: #189a1c;
    border-color: #0f8513;
}

.btn.btn-green:hover {
    background-color: #0f8513;
    border-color: #0e7717;
}

.btn-primary {
    background-color: #0069ff;
    border-color: #0069ff;
}

.btn.btn-primary:hover {
    background-color: #0069ff;
    border-color: #0069ff;
}

.box {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,.12), 0 2px 4px 0 rgba(0,0,0,.08) !important;
    background: #363c44;
    border-top: 3px solid #0069ff;
}

.box-header {
    color: #cad1d8;
    background: #3a4049;
}

.box-header.with-border {
    border-bottom: 1px solid #0069ff;
}

.box.box-default {
    border-top-color: #0069ff;
}

.box-footer {
    border-top: 1px solid #0069ff;
    background-color: #0069ff;
}

.content-header>.breadcrumb>li>a {
    color: #cad1d8;
}

.breadcrumb>.active {
    color: #cad1d8;
}

.h1 .small, .h1 small, .h2 .small, .h2 small, .h3 .small, .h3 small, .h4 .small, .h4 small, .h5 .small, .h5 small, .h6 .small, .h6 small, h1 .small, h1 small, h2 .small, h2 small, h3 .small, h3 small, h4 .small, h4 small, h5 .small, h5 small, h6 .small, h6 small {
    color: #cad1d8;
}

.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
    border-top: 1px solid #3a4049;
}

.table>thead>tr>th {
    border-bottom: 2px solid #3a4049;
}

.table-hover>tbody>tr:hover {
    background-color: #363c44;
}

a {
    color: #007eff;
}

.nav-tabs-custom {
    background: #363c44;
}

.nav-tabs-custom>.nav-tabs>li.active {
    border-top-color: #0069ff;
}

.nav-tabs-custom>.nav-tabs>li.active>a {
    border-right-color: #0069ff;
    border-left-color: #0069ff;
    background: #3a4049;
}

.nav-tabs-custom>.nav-tabs>li>a {
    color: #9aa5b1;
}

.nav-tabs-custom>.nav-tabs>li.active>a, .nav-tabs-custom>.nav-tabs>li.active:hover>a {
    color: #9aa5b1;
}

input.form-control {
    padding: .75rem;
    background-color: #3a4049;
    border-width: 1px;
    border-color: #3a4049;
    border-radius: .25rem;
    color: #cad1d8;
    box-shadow: none;
    -webkit-transition: border .15s linear,box-shaodw .15s ease-in;
    transition: border .15s linear,box-shaodw .15s ease-in;
}

textarea.form-control {
    padding: .75rem;
    background-color: #3a4049;
    border-width: 1px;
    border-color: #3a4049;
    border-radius: .25rem;
    color: #cad1d8;
    box-shadow: none;
    -webkit-transition: border .15s linear,box-shaodw .15s ease-in;
    transition: border .15s linear,box-shaodw .15s ease-in;
}

.input-group .input-group-addon {
    border-color: #3a4049;
    background-color: #3a4049;
    color: #cad1d8;
}

.select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
    border: 1px solid #3a4049;
}

.select2-container--default .select2-selection--single {
    background-color: #3a4049;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #cad1d8;
}

.select2-container--default .select2-selection--multiple {
    background-color: #3a4049;
}

.select2-container--default .select2-selection--multiple {
    border: 1px solid #3a4049;
    border-radius: 0;
}

code {
    background-color: #3a4049;
    color: #0069ff;
    border: 1px solid rgba(0, 0, 0, .25);
}

.btn-default {
    background-color: hsl(210, 23%, 18%);
    color: #cad1d8;
    border-color: #606d7b;
}

.select2-results__option {
    background-color: #b5bcc1;
    color: #444;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #3c8dbc;
}

.modal-body {
    background: #363c44;
}

.modal-header {
    background: #3a4049;
    border-bottom-color: #3a4049;
}

.modal-footer {
    background: #3a4049;
    border-top-color: #3a4049;
}

@media (max-width: 991px) {
    .content-header>.breadcrumb {
        background: #363c44 !important;
    }
}

.nav-tabs-custom>.nav-tabs>li.active>a, .nav-tabs-custom>.nav-tabs>li.active:hover>a {
    background-color: #3a4049;
}

.select2-container--default .select2-results__option[aria-selected=true], .select2-container--default .select2-results__option[aria-selected=true]:hover {
    color: #fff;
}

.select2-dropdown {
    background-color: #3a4049;
    border: 1px solid #3a4049;
}
.select2-container--default.select2-container--focus .select2-selection--multiple, .select2-container--default .select2-search--dropdown .select2-search__field {
    border-color: #3a4049 !important;
    background-color: #3a4049;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #3a4049;
}

a {
    color: #288afb;
}

a:hover {
    color: #0069ff;
}

.form-control {
    border-color: #3a4049;
    background-color: #3a4049;
    color: #cad1d8;
}

.form-control[disabled], .form-control[readonly],
fieldset[disabled] .form-control {
    background-color: #3a4049;
    color: #cad1d8;
    cursor: not-allowed;
}

.well {
    min-height: 20px;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #515f6cbb;
    border: 1px solid #606d7b;
}

.well-lg {
    padding: 24px;
}

.well-sm {
    padding: 9px;
}

.small-box h3, .small-box p {
    color: #c3c3c3;
}

.small-box-footer {
    color: #288afb;
}

.small-box .icon {
    color: #cad1d8;
}

.bg-gray {
    background-color: #363c44 !important;
}

pre {
    color: #cad1d8;
    background-color: hsl(210, 23%, 18%);
    border-color: hsl(209, 20%, 25%);
}
</style>
    <body style="font-family: 'Inter', sans-serif;" class="skin-blue fixed">
        <div class="wrapper">
            <header class="main-header">
                <a style="border-top: 5px;" href="{{ route('index') }}" class="logo">
                    <img src="https://cdn.discordapp.com/attachments/987734229469253674/1012679062889697330/Purple_Dark_Blue_Modern_Letter_H_Logo_Technology.png" width="48" height="48" />
                </a>
            </header>
            <aside style="background-color: #363c44;" class="main-sidebar">
                <section class="sidebar">
                    <ul style="background-color: #363c44;" class="sidebar-menu">
                        <br>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.index') ?: 'active' }}">
                            <a href="{{ route('admin.index')}}">
                                <i data-feather="tool" style="margin-left: 12px;"></i> 
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.api') ?: 'active' }}">
                            <a href="{{ route('admin.api.index')}}">
                                <i data-feather="git-branch" style="margin-left: 12px;"></i>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.databases') ?: 'active' }}">
                            <a href="{{ route('admin.databases') }}">
                                <i data-feather="database" style="margin-left: 12px;"></i>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.locations') ?: 'active' }}">
                            <a href="{{ route('admin.locations') }}">
                                <i data-feather="navigation" style="margin-left: 12px;"></i>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.nodes') ?: 'active' }}">
                            <a href="{{ route('admin.nodes') }}">
                                <i data-feather="layers" style="margin-left: 12px;"></i>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.servers') ?: 'active' }}">
                            <a href="{{ route('admin.servers') }}">
                                <i data-feather="server" style="margin-left: 12px;"></i>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.users') ?: 'active' }}">
                            <a href="{{ route('admin.users') }}">
                                <i data-feather="users" style="margin-left: 12px;"></i>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.mounts') ?: 'active' }}">
                            <a href="{{ route('admin.mounts') }}">
                                <i data-feather="hard-drive" style="margin-left: 12px;"></i>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.nests') ?: 'active' }}">
                            <a href="{{ route('admin.nests') }}">
                                <i data-feather="archive" style="margin-left: 12px;"></i>
                            </a>
                        </li>
                    </ul>
                </section>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    @yield('content-header')
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    There was an error validating the data provided.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @foreach (Alert::getMessages() as $type => $messages)
                                @foreach ($messages as $message)
                                    <div class="alert alert-{{ $type }} alert-dismissable" role="alert">
                                        {!! $message !!}
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    @yield('content')
                </section>
            </div>
        </div>
        @section('footer-scripts')
            <script src="/js/keyboard.polyfill.js" type="application/javascript"></script>
            <script>keyboardeventKeyPolyfill.polyfill();</script>

            {!! Theme::js('vendor/jquery/jquery.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/sweetalert/sweetalert.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/bootstrap/bootstrap.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/slimscroll/jquery.slimscroll.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/adminlte/app.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/bootstrap-notify/bootstrap-notify.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/select2/select2.full.min.js?t={cache-version}') !!}
            {!! Theme::js('js/admin/functions.js?t={cache-version}') !!}
            <script src="/js/autocomplete.js" type="application/javascript"></script>

            <script>
                feather.replace()
            </script>

            @if(Auth::user()->root_admin)
                <script>
                    $('#logoutButton').on('click', function (event) {
                        event.preventDefault();

                        var that = this;
                        swal({
                            title: 'Do you want to log out?',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d9534f',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Log out'
                        }, function () {
                             $.ajax({
                                type: 'POST',
                                url: '{{ route('auth.logout') }}',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },complete: function () {
                                    window.location.href = '{{route('auth.login')}}';
                                }
                        });
                    });
                });
                </script>
            @endif

            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                })
            </script>
        @show
    </body>
</html>
