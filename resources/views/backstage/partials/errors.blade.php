@if (count($errors) > 0)
    <div class="bg-red-100 border border-red-300 rounded px-4 py-2 text-sm">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
