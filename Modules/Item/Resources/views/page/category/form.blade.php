@component('component.summernote', ['array' => ['lite']])

@endcomponent
<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Flag', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'flag') ? 'has-error' : ''}}">
        {!! Form::text($form.'flag', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'flag', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'File', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'file') ? 'has-error' : ''}}">
        <input type="file" name="{{ $form.'file' }}"
            class="{{ $errors->has($form.'file') ? 'has-error' : ''}} btn btn-default btn-sm btn-block">
        {!! $errors->first($form.'file', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Homepage & Active', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-2 {{ $errors->has($form.'homepage') ? 'has-error' : ''}}">
        {{ Form::select($form.'homepage', ['0' => 'No', '1' => 'Yes'], $model->item_category_homepage ?? null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'homepage', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-md-2 {{ $errors->has($form.'status') ? 'has-error' : ''}}">
        {{ Form::select($form.'status', ['1' => 'Yes', '0' => 'No'], $model->item_category_status ?? null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>