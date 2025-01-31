@extends('backstage.templates.backstage')

@section('tools')
    @if( auth()->user()->hasLevel('admin') || auth()->user()->hasLevel('download') )
        <form method="POST" action="{{ route('backstage.games.export') }}">
            @csrf

            <!-- Apends get parameters as fields -->
            @foreach( request()->query() as $key => $value )
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <div class="grid grid-cols-4 gap-4 items-start pt-5">
                <div class="col-start-2 col-span-3">
                    <button type="submit" class="submit-button">
                        Export csv
                    </button>
                </div>
            </div>
        </form>
    @endif
@endsection

@section('content')
    <div id="card" class="bg-white shadow-lg mx-auto rounded-b-lg">
        <div class="px-10 pt-4 pb-8">
            @livewire('backstage.game-table')
        </div>
    </div>
@endsection
