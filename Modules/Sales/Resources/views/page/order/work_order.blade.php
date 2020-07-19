@extends(Helper::setExtendBackend())
@component('component.select2')
@endcomponent
@component('component.mask', ['array' => ['number', 'money']])
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
                @isset($form)
                <h2 class="panel-title">Split WO From : {{ $model->$key }}</h2>
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
    @include($folder.'::page.order.table_work_order')
    @include($folder.'::page.order.action')
    {!! Form::close() !!}
</div>

@endsection

@push('javascript')
<script>
    $(function() {
        $('#transaction').arrowTable({
            focusTarget: 'input, textarea',
            enabledKeys: ['up', 'down', 'right', 'left']
        });
    });
</script>
@endpush