<?php /** @var \Thunderbite\Importer\Models\Import $import */ ?>
<?php /** @var string $ajaxUrl */ ?>

<div class="{{ \Thunderbite\Importer\Importer::cardClass() }}" id="panel-rows">
    <div class="{{ \Thunderbite\Importer\Importer::cardHeaderClass() }}">Rows list</div>
    <div class="{{ \Thunderbite\Importer\Importer::cardBodyClass() }}">
        @if($import->pruned_at)
            Unavailable for old imports.
        @else
            <table class="table table-hover" id="rows">

                <thead>
                <tr>
                    <th>Row&nbsp;№</th>
                    <th>Contents</th>
                    <th>Status</th>
                </tr>
                </thead>

                <tbody></tbody>

            </table>
        @endif
    </div>
</div>

@push('js')
    @unless($import->pruned_at)
        <script>
            $(function () {
                $('#rows').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ $ajaxUrl }}',
                        data: function (d) {
                            d.status = $('#status-filter').val() || 'all';
                        }
                    },
                    columns: [
                        {data: 'row_number', name: 'row_number', searchable: false},
                        {
                            data: 'contents',
                            name: 'contents',
                            orderable: false,
                            render: function (data, type, row, meta) {
                                return '<pre class="text-xs bg-grey-lightest p-2 rounded">' + data + '</pre>';
                            }
                        },
                        {
                            data: 'errors',
                            name: 'messages',
                            orderable: false,
                            searchable: true,
                            render: function (data, type, row, meta) {
                                if (data === null) {
                                    return '<span class="text-success"><b>Row was successfully imported.</b></span>';
                                } else {
                                    return '<span class="text-danger"><b>Invalid data:</b></span>' + data;
                                }
                            }
                        },
                    ],
                    sDom: 'lrtip',
                });

                $('<div class="pull-right">' +
                    '<label>Filter by status: ' +
                    '<select id="status-filter" class="form-control input-sm" style="width: auto">' +
                    '<option value="all">All rows</option>' +
                    '<option value="success">Only valid</option>' +
                    '<option value="error">Only invalid</option>' +
                    '</select>' +
                    '</label>' +
                    '</div>').appendTo("#rows_length");
                $("#status-filter").change(function () {
                    $('#rows').DataTable().ajax.reload();
                });

            });
        </script>
    @endunless
@endpush
