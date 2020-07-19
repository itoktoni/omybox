@component('component.select2')
@endcomponent

<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Type', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'type') ? 'has-error' : ''}}">
        {{ Form::select($form.'type', $status, null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Flag', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'flag') ? 'has-error' : ''}}">
        <select class="form-control input-sm mb-md" multiple id="group_module" name="flag[]">
            @foreach($flag as $key => $value)
            <option {{ isset($model) && in_array($key, json_decode($model->{$form.'flag'})) ? 'selected' : '' }} value="{{ $key }}">
                {{ ucwords(str_replace('_', ' ', $value)) }}</option>
            @endforeach
        </select>
        {!! $errors->first($form.'flag', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>