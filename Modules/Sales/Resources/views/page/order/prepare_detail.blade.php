<div class="panel-body {{ $errors->has('temp_id') ? 'has-error' : ''}}">
    <div class="panel panel-default">

        <div class="panel-body line">
            <div class="col-md-12 col-lg-12">
                @include($folder.'::page.'.$template.'.prepare_table')
            </div>
        </div>

    </div>
</div>
