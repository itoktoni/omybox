@extends(Helper::setExtendBackend())
@component('component.mask', ['array' => ['number', 'date', 'money']])
@endcomponent
@component('component.readonly', ['array' => ['input', 'select'], 'selector' => '#input-form'])
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
                <h2 class="panel-title">Create Payment : {{ $model->$key }}</h2>
            </header>

            <div class="panel-body line">
                <div class="col-md-12 col-lg-12">
                    @includeIf(Helper::include($template))
                </div>
            </div>
        </div>
    </div>
    @include($folder.'::page.'.$template.'.form_payment')
    @include($template_action)
    {!! Form::close() !!}
</div>

@endsection