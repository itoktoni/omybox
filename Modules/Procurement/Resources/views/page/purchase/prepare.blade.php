@extends(Helper::setExtendBackend())
@component('component.mask', ['array' => ['money', 'number']])
@endcomponent
@component('component.readonly', ['array' => ['input'], 'selector' => '#input-form'])
@endcomponent
@section('content')
<div class="row">
    @isset($model->$key)
    {!! Form::model($model, ['route'=>[$action_code, 'code' => $model->$key],'class'=>'form-horizontal','files'=>true])
    !!}
    @else
    {!! Form::open(['route' => $action_code, 'class' => 'form-horizontal', 'files' => true]) !!}
    @endisset
    <div class="panel-body">
        <div class="panel panel-default">
            <header class="panel-heading">
                @isset($form)
                <h2 class="panel-title">Edit {{ ucwords(str_replace('_',' ',$template)) }} {{ $model->$key }}</h2>
                @else
                <h2 class="panel-title">Create {{ ucwords(str_replace('_',' ',$template)) }}</h2>
                @endisset
            </header>

            <div class="panel-body line">
                <div class="col-md-12 col-lg-12">
                    @includeIf(Helper::include($template))
                    <hr>
                    <div class="form-group">
                        {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10 {{ $errors->has('purchase_notes_vendor') ? 'has-error' : ''}}">
                            {!! Form::textarea('purchase_notes_vendor', null, ['class' => 'form-control', 'rows' => '3']) !!}
                            {!! $errors->first('purchase_notes_vendor', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include(ucfirst($folder).'::page.'.$template.'.prepare_detail')
    @include($folder.'::page.'.$template.'.action')
    {!! Form::close() !!}
</div>

@endsection