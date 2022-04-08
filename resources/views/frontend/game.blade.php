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
        <pre id="results"></pre>

        <button class="button">Spin</button>
    </div>

    <script src="{{ mix('/js/app.js') }}"></script>

    @livewireScripts

    @stack('js')

    <script>
        window.addEventListener('load', function() {
            const spinButton = document.querySelector('button');
            const resultsDiv = document.getElementById('results');
            spinButton.addEventListener('click', function() {
                axios.get("{{ url('/api/' . $campaign->slug) }}")
                    .then(function(response) {
                        resultsDiv.innerHTML = JSON.stringify(response.data);
                    })
            });
        });
    </script>

    @include('backstage.partials.flash-messages')

</body>

</html>
