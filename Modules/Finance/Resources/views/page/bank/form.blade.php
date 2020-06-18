<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Branch', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'branch') ? 'has-error' : ''}}">
        {!! Form::text($form.'branch', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'branch', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Account Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'account_name') ? 'has-error' : ''}}">
        {!! Form::text($form.'account_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'account_name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Account Number', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'account_number') ? 'has-error' : ''}}">
        {!! Form::text($form.'account_number', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'account_number', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>