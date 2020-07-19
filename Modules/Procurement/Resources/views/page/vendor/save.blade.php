@extends(Helper::setExtendBackend())
@component('component.mask', ['array' => ['money', 'number']])
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
                </div>
            </div>
        </div>
    </div>
    @include($folder.'::page.'.$template.'.detail')
    @include($template_action)
    {!! Form::close() !!}
</div>

@endsection