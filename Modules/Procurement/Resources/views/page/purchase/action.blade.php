<div class="navbar-fixed-bottom" id="menu_action">
        <div class="text-right" style="padding:5px">
                @switch($action_function)
                @case('data')
                @isset($action['create'])
                <a href="{!! route($module.'_create') !!}" class="btn btn-success">Create</a>
                @endisset
                @isset($action['delete'])
                <button type="submit" value="delete" name="action" class="btn btn-danger">Delete</button>
                @endisset
                @break

                @case('create')
                <a id="linkMenu" href="{!! route($module.'_data') !!}" class="btn btn-warning">Back</a>
                <button type="reset" class="btn btn-default">Reset</button>
                @isset($action['create'])
                <button type="submit" class="btn btn-primary">Save</button>
                @endisset
                @break

                @case('update')
                <a id="linkMenu" href="{!! route($module.'_data') !!}" class="btn btn-warning">Back</a>
                <button type="reset" class="btn btn-default">Reset</button>
                @isset($action['update'])
                <a target="__blank" id="linkMenu"
                        href="{!! route($module.'_print_order', ['code'=> $model->{$key}]) !!}" class="btn
                        btn-danger">PDF</a>
                @if ($model->status == 1)
                <button type="submit" class="btn btn-primary">Save</button>
                @endif
                @endisset
                @break

                @case('prepare')
                <a id="linkMenu" href="{!! route($module.'_data') !!}" class="btn btn-warning">Back</a>
                <button type="reset" class="btn btn-default">Reset</button>
                @if($model->purchase_status > 2)
                <a id="linkMenu" target="__blank" href="{!! route($module.'_print_delivery', ['code'=> $model->{$key}])
                        !!}" class="btn
                        btn-danger">PDF</a>
                @endif
                @if($model->purchase_status <= 2)        
                <button type="submit" class="btn btn-primary">Save</button>
                @endif
                @break

                @case('receive')
                <a id="linkMenu" href="{!! route($module.'_data') !!}" class="btn btn-warning">Back</a>
                <button type="reset" class="btn btn-default">Reset</button>
                @if($model->purchase_status == 3)
                <button type="submit" class="btn btn-primary">Save</button>
                @endif
                @if(Auth::user()->group_user == 'developer')
                <button name="action" value="revisi" type="submit" class="btn btn-primary">Revisi</button>
                @endif
                @break

                @case('work_order')
                <a id="linkMenu" href="{!! route($module.'_data') !!}" class="btn btn-warning">Back</a>
                <button type="reset" class="btn btn-default">Reset</button>
                @isset($action['work_order'])
                <button type="submit" class="btn btn-primary">Save</button>
                @endisset
                @break

                @case('show')
                <a id="linkMenu" href="{!! route($module.'_data') !!}" class="btn btn-warning">Back</a>
                @isset($action['print_order'])
                <a id="linkMenu" href="{!! route(trim(" {$module}_print_order"), ["code"=> $model->{$key}]) !!}"
                        class="btn btn-danger">Pdf</a>
                @endisset
                @isset($action['update'])
                <a id="linkMenu" href="{!! route(trim(" {$module}_update"), ["code"=> $model->{$key}]) !!}" class="btn
                        btn-primary">Edit</a>
                @endisset
                @break
                @endswitch
        </div>
</div>