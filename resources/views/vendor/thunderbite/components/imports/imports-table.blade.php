<?php /** @var string $ajaxUrl */ ?>
<?php /** @var ?array $ajaxData */ ?>
<?php /** @var ?string $tableId */ ?>

<div class="{{ \Thunderbite\Importer\Importer::cardClass() }}">
    <div class="{{ \Thunderbite\Importer\Importer::cardHeaderClass() }}">Imports list</div>
    <div class="{{ \Thunderbite\Importer\Importer::cardBodyClass() }}">
        <table class="table table-hover" id="{{ $tableId ?? 'imports' }}" style="width: 100%">

            <thead>
            <tr>
                <th rowspan="2">Uploaded</th>
                <th rowspan="2">Filename</th>
                <th rowspan="2">Processed</th>
                <th colspan="3">Rows</th>
                <th rowspan="2">Actions</th>
            </tr>
            <tr>
                <th>Total</th>
                <th><i class="fa fa-check"></i></th>
                <th><i class="fa fa-times"></i></th>
            </tr>
            </thead>

            <tbody></tbody>

        </table>
    </div>
</div>

@push('js')
    <script>
        $(function () {
            $('#{{ $tableId ?? 'imports' }}').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ $ajaxUrl }}',
                    data: function (d) {
                        @isset($ajaxData)
                            @foreach($ajaxData as $key => $value)
                            d.{{ $key }} = {{ $value }};
                        @endforeach
                        @endisset
                    },
                },
                columns: [
                    {data: 'created_at', name: 'created_at', searchable: true},
                    {data: 'original_filename', name: 'original_filename'},
                    {
                        data: 'processed_at', name: 'processed_at', orderable: false, searchable: true,
                        render: (data, type, row) => data || (row['failed_at'] !== null ? 'Failed' : 'Processing…'),
                    },
                    {
                        data: 'rows_total_count', name: 'rows_total_count', orderable: false, searchable: false,
                        render: (data, type, row) => row['processed_at'] !== null ? data : ''
                    },
                    {
                        data: 'rows_success_count', name: 'rows_success_count', orderable: false, searchable: false,
                        render: (data, type, row) => row['processed_at'] !== null ? data : ''
                    },
                    {
                        data: 'rows_error_count', name: 'rows_error_count', orderable: false, searchable: false,
                        render: (data, type, row) => row['processed_at'] !== null ? data : ''
                    },
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                ],
                "order": [[0, "desc"]]
            });

        });
    </script>
@endpush
