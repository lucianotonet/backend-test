@extends('templates.backstage')

@section('tools')

@endsection

@section('content')
    <div id="card" class="bg-white shadow-lg mx-auto rounded-b-lg">
        <div class="px-10 pt-4 pb-8">
            <div class="flex flex-col">
                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                    <div class="align-middle inline-block min-w-full overflow-hidden">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="table-header">Attribute</th>
                                    <th class="table-header">Old</th>
                                    <th class="table-header">New</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $data as $name => $values )
                                    <tr class="@if( (++$i) % 2 === 0 ) alternate @endif">
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                            {{ ucfirst($name) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                            {{ $values['old'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                            {{ $values['new'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
