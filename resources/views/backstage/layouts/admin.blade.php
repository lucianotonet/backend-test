<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="{{ mix('/css/backstage.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body id="app">

<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ auth()->user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item" href="/backstage/users/{{ auth()->user()->id }}/edit">
                                <i class="far fa-user-cog fa-fw"></i> Profile
                            </a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="far fa-sign-out-alt fa-fw"></i> {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>


<div class="container">

    @if( isset($fatalError) )
        @include('partials.fatal')
    @endif

    <div class="row mt-3 mb-3">
        <div class="col-sm-6">
            <h1 style="font-size: 18px; line-height: 18px; margin: 0 0 20px 0; padding: 0;">

                @if( !is_null($currentCampaign) )
                    {{ $currentCampaign->name }}<br/>
                    <small>
                        <a href="{{ Request()->secure() ? secure_url($currentCampaign->slug) : url($currentCampaign->slug) }}"
                           target="_blank" class="alert-link">
                            {{ Request()->secure() ? secure_url($currentCampaign->slug) : url($currentCampaign->slug) }}
                        </a>
                    </small>
                @endif

            </h1>
        </div>
        <div id="moduleNav" class="col-sm-6">
            @yield('moduleNav')
        </div>
    </div>

    <div class="row">

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Navigation</div>

                <div id="appNav" class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                     aria-orientation="vertical">
                    <!-- Links which are always visible -->
                    <a href="/backstage/campaigns"
                       class="nav-link @if( request()->segment(2) == 'campaigns' ) active @endif">
                        <i class="fa fa-bullhorn fa-fw"></i> Campaigns
                    </a>

                    @if( !is_null($currentCampaign) )

                        <div class="nav-sub-items">

                            <a href="/backstage/games"
                               class="nav-link @if(request()->segment(2) == 'games') active @endif">
                                <i class="far fa-dice fa-fw"></i> Games
                            </a>

                            <a href="/backstage/prizes"
                               class="nav-link @if(request()->segment(2) == 'prizes') active @endif">
                                <i class="far fa-trophy fa-fw"></i> Prizes
                            </a>

                        </div>

                    @endif

                    <a href="/backstage/users" class="nav-link @if(request()->segment(2) == 'users') active @endif">
                        <i class="far fa-users fa-fw"></i> Users
                    </a>

                </div>
            </div>

        </div>

        <div class="col-md-9">

            @include('backstage.layouts.partials.notifications')

            @yield('content')
        </div>

    </div>

</div>


<script type="text/javascript">
    var token = "{{ csrf_token() }}";
</script>

<script src="{{ mix('/js/backstage.js') }}"></script>

@stack('js')

@if( session()->has('error') )
    <script type="text/javascript">
        swal({
            title: "Whoops!",
            text: "{{ session('error') }}",
            timer: 1500,
            buttons: false,
            icon: 'error'
        });
    </script>
@endif

@if( session()->has('success') )
    <script type="text/javascript">
        swal({
            title: "Well done!",
            text: "{{ session('success') }}",
            timer: 1500,
            buttons: false,
            icon: 'success'
        });
    </script>
@endif

</body>
</html>
