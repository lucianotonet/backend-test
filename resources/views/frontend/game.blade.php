<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    @livewireStyles

</head>

<body class="bg-primary">

    <!-- Content -->
    <div class="container mx-auto p-10 relative z-10 flex flex-col items-center justify-center h-full">

        {{-- Just for the test --}}
        <div id="results" class="bg-slate-100 p-8">You have {{ $game->spins_limit }} spins today.@if ($game->spins_limit)
                <br />Press button to start the game.
            @endIf
        </div>

        <div class="flex justify-around w-96 py-8 my-5">
            <div>
                Points: <span id="points">0</span>
            </div>
            <div>
                Remain spins: <span id="remainSpins">{{ $game->spins_limit }}</span>
            </div>
        </div>

        <button class="button">Spin</button>
    </div>

    <script src="{{ mix('/js/app.js') }}"></script>

    @livewireScripts

    @stack('js')

    <script>
        window.addEventListener('load', function() {
            const spinButton = document.querySelector('button');
            const resultsDiv = document.getElementById('results');
            const remainSpins = document.getElementById('remainSpins');
            const points = document.getElementById('points');
            spinButton.addEventListener('click', function() {
                axios.get("{{ url('/api/' . $campaign->slug . '?a=username') }}")
                    .then(function(response) {
                        if (response.data.error) {
                            swal({
                                title: "Oops!",
                                text: response.data.error,
                                icon: "warning",
                                buttons: true,
                            });
                            return
                        }
                        resultsDiv.innerHTML = JSON.stringify(response.data.symbols);
                        points.innerHTML = JSON.stringify(response.data.points);
                        remainSpins.innerHTML = JSON.stringify(response.data.spins_remain);
                    })
            });
        });
    </script>

    @include('backstage.partials.flash-messages')

</body>

</html>
