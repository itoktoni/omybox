@component('component.date', ['array' => ['date']])
@endcomponent

@extends(Helper::setExtendBackend())
@section('content')
<div class="row">
    <div class="panel-body">
        {!! Form::open(['route' => $action_code, 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="panel panel-default">
            <header class="panel-heading">
                <h2 class="panel-title">Report {{ ucwords(str_replace('_',' ',$template)) }}</h2>
            </header>

            <div class="panel-body line">
                <div class="col-md-12 col-lg-12">
                    
                    <div class="form-group">
                    
                        {!! Form::label('name', 'Date From', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has($form.'homepage') ? 'has-error' : ''}}">
                           {!! Form::text('from', null, ['class' => 'date']) !!}
                            {!! $errors->first($form.'homepage', '<p class="help-block">:message</p>') !!}
                        </div>
                        {!! Form::label('name', 'Date To', ['class' => 'col-md-1 control-label']) !!}
                        <div class="col-md-5 {{ $errors->has($form.'status') ? 'has-error' : ''}}">
                            {!! Form::text('from', null, ['class' => 'date']) !!}
                            {!! $errors->first($form.'status', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div class="form-group">

                        {!! Form::label('name', 'Product', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has($form.'homepage') ? 'has-error' : ''}}">
                            {{ Form::select('product', $product, old('product') ?? null, ['class'=> 'form-control']) }}
                            {!! $errors->first($form.'homepage', '<p class="help-block">:message</p>') !!}
                        </div>
                        {!! Form::label('name', 'Size', ['class' => 'col-md-1 control-label']) !!}
                        <div class="col-md-2 {{ $errors->has($form.'status') ? 'has-error' : ''}}">
                            {{ Form::select('size', $size, old('size') ?? null, ['class'=> 'form-control']) }}
                            {!! $errors->first($form.'status', '<p class="help-block">:message</p>') !!}
                        </div>
                        {!! Form::label('name', 'Color', ['class' => 'col-md-1 control-label']) !!}
                        <div class="col-md-2 {{ $errors->has($form.'status') ? 'has-error' : ''}}">
                            {{ Form::select('color', $color, old('color') ?? null, ['class'=> 'form-control']) }}
                            {!! $errors->first($form.'status', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                </div>
            </div>

            <div class="navbar-fixed-bottom" id="menu_action">
                <div class="text-right" style="padding:5px">
                    <button type="submit" value="export" name="action" class="btn btn-success">Export</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection