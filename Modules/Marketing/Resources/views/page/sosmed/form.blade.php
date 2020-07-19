@component('component.summernote', ['array' => ['basic']])

@endcomponent
<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Icon', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'icon') ? 'has-error' : ''}}">
        {!! Form::text($form.'icon', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'icon', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Link', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'link') ? 'has-error' : ''}}">
        {!! Form::text($form.'link', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'link', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Detail Icon', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        <a class="btn btn-success btn-sm btn-block" target="_blank" href="https://fontawesome.com/v4.7.0/icons/">Go to Font
            Awesome</a>
    </div>

</div>