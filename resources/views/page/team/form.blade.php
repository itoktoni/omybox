<div class="form-group">
    <label class="col-md-2 control-label">Name</label>
    <div class="col-md-4 {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>

    <label class="col-md-2 control-label">Email</label>
    <div class="col-md-4 {{ $errors->has('email') ? 'has-error' : ''}}">
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Username</label>
    <div class="col-md-4 {{ $errors->has('username') ? 'has-error' : ''}}">
        {!! Form::text('username', null, ['class' => 'form-control', 'autocomplete' => false]) !!}
        {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
    </div>

    <label class="col-md-2 control-label">Password</label>
    <div class="col-md-4 {{ $errors->has('password') ? 'has-error' : ''}}">
        {!! Form::password('password', ['class' => 'form-control','autocomplete' => false]) !!}
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Group</label>
    <div class="col-md-4 {{ $errors->has('group_user') ? 'has-error' : ''}}">
        {{ Form::select('group_user', $group, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
    </div>

    <label class="col-md-2 control-label">Active</label>
    <div class="col-md-4 {{ $errors->has('active') ? 'has-error' : ''}}">
        {{ Form::select('active', $status, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Brand', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('brand') ? 'has-error' : ''}}">
        {{ Form::select('brand', $brand, $model->brand ?? null, ['class'=> 'form-control']) }}
        {!! $errors->first('brand', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('address', 'Address', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('address') ? 'has-error' : ''}}">
        {!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => 3]) !!}
        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
    </div>

</div>