<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>
    {!! Form::label('email', 'Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'email') ? 'has-error' : ''}}">
        {!! Form::text($form.'email', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('contact', 'Contact', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'contact') ? 'has-error' : ''}}">
        {!! Form::text($form.'contact', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'contact', '<p class="help-block">:message</p>') !!}
    </div>
    {!! Form::label('name', 'Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'phone') ? 'has-error' : ''}}">
        {!! Form::text($form.'phone', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Address', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'address') ? 'has-error' : ''}}">
        {!! Form::textarea($form.'address', null, ['class' => 'form-control', 'rows' => '3']) !!}
        {!! $errors->first($form.'address', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'description') ? 'has-error' : ''}}">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
        {!! $errors->first($form.'description', '<p class="help-block">:message</p>') !!}
    </div>
   
</div>