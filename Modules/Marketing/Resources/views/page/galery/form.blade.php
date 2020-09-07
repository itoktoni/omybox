@component('component.summernote', ['array' => ['basic']])

@endcomponent
<div class="form-group">

    {!! Form::label('name', 'Image', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'file') ? 'has-error' : ''}}">
        <input type="hidden" value="{{ $form.'image' }}" name="$form.'image'">
        <input type="file" name="{{ $form.'file' }}"
            class="{{ $errors->has($form.'file') ? 'has-error' : ''}} btn btn-default btn-sm btn-block">
        {!! $errors->first($form.'file', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Link', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'link') ? 'has-error' : ''}}">
        {!! Form::text($form.'link', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'link', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Order', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'order') ? 'has-error' : ''}}">
        {!! Form::text($form.'order', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'order', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '5']) !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Tag', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has($form.'tag') ? 'has-error' : ''}}">
        {{ Form::select('tag_json[]', $tag, $data_tag ?? [], ['class'=> 'form-control choosen', 'multiple']) }}
        {!! $errors->first($form.'tag', '<p class="help-block">:message</p>') !!}
    </div>