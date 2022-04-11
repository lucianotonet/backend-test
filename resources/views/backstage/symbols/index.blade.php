@extends('backstage.templates.backstage')

@section('tools')
    @if (auth()->user()->isAdmin() && $symbols->count() < 10)
        <a href="{{ route('backstage.symbols.create') }}" class="button-create">Add symbol</a>
    @endif
@endsection

@section('content')
    <div id="card" class="bg-white shadow-lg mx-auto rounded-b-lg">
        <div class="px-10 pt-4 pb-8">
            @livewire('backstage.symbol-table')
        </div>
    </div>
@endsection
