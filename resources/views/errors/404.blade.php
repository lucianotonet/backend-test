<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>404 - {{ env('APP_NAME') }}</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{ mix('/css/errors.css') }}" rel="stylesheet">

    </head>

    <body>
        <div class="flex items-center justify-center h-screen">
            <div class="container mx-auto max-w-4xl">
                <div class="flex grid items-center grid-cols-2 gap-4">
                    <div>
                        <h1 class="text-6xl font-bold m-0 p-0 leading-none pb-4">404</h1>
                        <p class="text-lg leading-none">Sorry, what you are looking for could not be found.</p></div>
                    <div>
                        <img src="errors/geek-cab.png">
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
