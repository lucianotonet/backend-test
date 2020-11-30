<?php /** @var string $url */ ?>

<div class="{{ \Thunderbite\Importer\Importer::cardClass() }}">
    <div class="{{ \Thunderbite\Importer\Importer::cardHeaderClass() }}">New import</div>
    <div class="{{ \Thunderbite\Importer\Importer::cardBodyClass() }}">
        {!! Form::open( ['url' => $url, 'class' => 'validateForm form-horizontal', 'role' => 'form', 'files' => true] ) !!}

        <div class="form-group row{{ $errors->has('file') ? ' has-error' : '' }}">
            {!! Form::label('file', 'CSV file', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::file('file', ['class' => 'fileInput', 'accept' => '.csv,text/plain']) !!}
                @if ($errors->has('file'))
                    <span class="error-message">
                        <strong>{{ $errors->first('file') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        {{ $slot }}

        <div class="form-group row">
            <div class="{{ \Thunderbite\Importer\Importer::submitBtnWrapperClass() }}">
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>

@push('js')
    <script>
        $(function () {
            $(".fileInput").fileinput({
                'showUpload': false,
                'showPreview': false,
                'showCancel': false,
            });
        });
    </script>
@endpush
