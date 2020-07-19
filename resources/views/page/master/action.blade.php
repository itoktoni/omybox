<div class="navbar-fixed-bottom" id="menu_action">
        <div class="text-right" style="padding:5px">
                @switch($action_function)
                @case('data')
                @isset($action['create'])
                <a href="{!! route($module.'_create') !!}" class="btn btn-success">Create</a>
                @endisset
                @isset($action['delete'])
                <button type="submit" onclick="return confirm('Are you sure to delete data ?');" id="delete-action"
                        value="delete" name="action" class="btn btn-danger">Delete</button>
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
                <button type="submit" class="btn btn-primary">Save</button>
                @endisset
                @break

                @case('show')
                <a id="linkMenu" href="{!! route($module.'_data') !!}" class="btn btn-warning">Back</a>
                @isset($action['update'])
                <a id="linkMenu" href="{!! route(trim(" {$module}_update"), ["code"=> $model->{$key}]) !!}" class="btn
                        btn-primary">Edit</a>
                @endisset
                @break
                @endswitch
        </div>
</div>