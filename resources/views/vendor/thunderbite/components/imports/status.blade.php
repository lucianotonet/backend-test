<?php /** @var \Thunderbite\Importer\Models\Import $import */ ?>
<?php /** @var int $totalCount */ ?>
<?php /** @var int $successCount */ ?>
<?php /** @var int $errorCount */ ?>
<?php /** @var string $downloadUrl */ ?>
<?php /** @var string $ajaxUrl */ ?>
<?php
/** @var int $percentProcessed */
$percentProcessed = !$import->processed_at ? round(($successCount + $errorCount) * 100 / $totalCount) : 100
?>

<div class="{{ \Thunderbite\Importer\Importer::cardClass() }}">
    <div class="{{ \Thunderbite\Importer\Importer::cardHeaderClass() }}">Import status</div>
    <div class="{{ \Thunderbite\Importer\Importer::cardBodyClass() }}">
        <div class="progress" style="background-color: lightblue">
            <div id="progress"
                 class="progress-bar {{ ! $import->processed_at && ! $import->failed_at ? 'progress-bar-striped' : '' }} {{ $import->failed_at ? 'progress-bar-danger' : ($import->processed_at ? 'progress-bar-success' : '') }} progress-bar-animated active"
                 role="progressbar"
                 aria-valuenow="{{ $import->failed_at ? '100' : $percentProcessed }}" aria-valuemin="0"
                 aria-valuemax="100"
                 style="width:{{ $import->failed_at ? '100' : $percentProcessed }}%">
                {{ $import->failed_at ? 'Failed' : $percentProcessed.'% Complete' }}
            </div>
        </div>
        <table class="table">

            <tbody>
            <tr>
                <td>
                    Uploaded:
                </td>
                <td>
                    {{ $import->created_at  }}
                </td>
            </tr>
            <tr style="border-bottom-style: double;">
                <td>
                    Filename:
                </td>
                <td>
                    {{ $import->original_filename  }} @unless($import->pruned_at)<a
                            href="{{ $downloadUrl }}" title="Download"> <i
                                class="fa fa-download"></i></a>@endunless
                </td>
            </tr>
            <tr style="font-weight: bold">
                <td>
                    Total number of rows:
                </td>
                <td id="total-count">
                    {{ $totalCount }} @unless($import->processed_at) (estimated) @endunless
                </td>
            </tr>
            <tr class="text-success">
                <td>
                    Successfully imported:
                </td>
                <td id="success-count">
                    {{ $successCount }}
                </td>
            </tr>
            <tr class="text-danger">
                <td>
                    Rows with errors:
                </td>
                <td id="error-count">
                    {{ $errorCount }}
                </td>
            </tr>
            </tbody>

        </table>
    </div>
</div>

@push('js')
    @unless($import->processed_at || $import->failed_at)
        <script>
            const $totalCount = $('#total-count');
            const $successCount = $('#success-count');
            const $errorCount = $('#error-count');
            const $progress = $("#progress");
            const $panelRows = $("#panel-rows");

            const totalCount = parseInt('{{ $totalCount }}');

            function fetchProcessingStatus() {
                $.ajax({
                    url: '{{ $ajaxUrl }}',
                    type: 'get',
                    success: function (data) {
                        const {processed, failed, successCount, errorCount} = data;

                        if (failed) {
                            $successCount.text(0);
                            $errorCount.text(0);
                            $progress
                                .css("width", 100 + "%")
                                .attr("aria-valuenow", 100)
                                .text("Failed")
                                .removeClass('progress-bar-striped')
                                .addClass('progress-bar-danger');
                        } else {
                            const percentProcessed = processed ? 100 : Math.round((successCount + errorCount) * 100 / totalCount);

                            $successCount.text(successCount);
                            $errorCount.text(errorCount);
                            $progress
                                .css("width", percentProcessed + "%")
                                .attr("aria-valuenow", percentProcessed)
                                .text(percentProcessed + "% Complete");
                            if (processed) {
                                $totalCount.text(successCount + errorCount);
                                $progress
                                    .removeClass('progress-bar-striped')
                                    .addClass('progress-bar-success');
                                swal({
                                    title: "Success!",
                                    text: "Your CSV has been processed.",
                                    timer: 1500,
                                    showConfirmButton: false,
                                    type: 'success'
                                });
                                $('#rows').DataTable().ajax.reload();
                                $panelRows.show();
                            }
                        }


                    },
                    complete: function (data) {
                        if (!data['responseJSON']['processed'] && !data['responseJSON']['failed']) {
                            setTimeout(fetchProcessingStatus, 5000);
                        }
                    }
                });
            }

            $(document).ready(function () {
                setTimeout(fetchProcessingStatus, 1500);
            });
        </script>
    @endunless
@endpush
