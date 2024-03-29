<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'User Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'email') ? 'has-error' : ''}}">
        {{ Form::select($form.'email', $user, $model->item_brand_email ?? null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'email', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'phone') ? 'has-error' : ''}}">
        {!! Form::text($form.'phone', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'phone', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>