@extends('templates.backstage')

@section('tools')
    <a href="{{ route('backstage.'.$model.'.index') }}" class="button-log">{{ ucfirst($model) }}</a>
@endsection

@section('content')
    <div id="card" class="bg-white shadow-lg mx-auto rounded-b-lg">
        <div class="px-10 pt-4 pb-8">
            @livewire('backstage.logs-table', ['model' => $model])
        </div>
    </div>
@endsection
