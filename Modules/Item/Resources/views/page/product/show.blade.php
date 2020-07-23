@extends(Helper::setExtendBackend())
@section('content')
<div class="row">

    <div class="panel-body">
        {!! Form::model($model, ['route'=>[$action_code, 'code' => $model->$key],'class'=>'form-horizontal
        ','files'=>true])
        !!}

        <div class="panel panel-default">

            <header class="panel-heading">
                <h2 class="panel-title">{{ $model->item_product_name }}</h2>
            </header>


            <div class="panel-body line">
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">

                        <input type="hidden" value="{{ $model->item_product_id }}" name="item_material_item_product_id">

                        {!! Form::label('name', 'Raw Material', ['class' => 'col-md-2 control-label']) !!}
                        <div
                            class="col-md-4 {{ $errors->has('item_material_procurement_product_id') ? 'has-error' : ''}}">
                            <select class="form-control col-md-4" id="product"
                                name="item_material_procurement_product_id">
                                <option value="">Select Product</option>
                                @foreach($raw as $value)
                                <option value="{{ $value->procurement_product_id }}">
                                    {{ $value->procurement_product_name }} / {{ $value->unit->procurement_unit_name ?? '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {!! Form::label('name', 'Raw Value', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('item_material_value') ? 'has-error' : ''}}">
                            {!! Form::text('item_material_value', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('item_material_value', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10 {{ $errors->has('item_material_description') ? 'has-error' : ''}}">
                            {!! Form::textarea('item_material_description', null, ['class' => 'form-control', 'rows' =>
                            3]) !!}
                            {!! $errors->first('item_material_description', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                </div>
            </div>
            @if($model->material)
                
            <hr>

            <div class="panel-body line">


                <table id="transaction" class="table table-no-more table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-left col-md-1">ID</th>
                            <th class="text-left col-md-2">Product Name</th>
                            <th class="text-right col-md-1">Value</th>
                            <th class="text-right col-md-1">Unit</th>
                            <th class="text-left col-md-3">Description</th>
                            <th id="action" class="text-center col-md-1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($model->material as $material)
                                <tr>
                                    <td>{{ $material->item_material_item_product_id }}</td>
                                    <td>{{ $material->product->procurement_product_name ?? '' }}</td>
                                    <td align="right">{{ $material->item_material_value }}</td>
                                    <td align="right">{{ $material->product->unit->procurement_unit_name ?? '' }}</td>
                                    <td>{{ $material->item_material_description }}</td>
                                    <td align="center"><a class="btn btn-danger btn-xs" href="{{ route($action_code, ['delete' => $material->item_material_id ]) }}">Delete</a></td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif


            @include($folder.'::page.'.$template.'.action')

        </div>
        {!! Form::close() !!}
        <br>

    </div>
</div>

@endsection