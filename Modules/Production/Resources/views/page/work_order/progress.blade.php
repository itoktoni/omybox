<div class="form-group">
    <table id="transaction" class="table table-no-more table-bordered table-striped">
        <thead>
            <tr>
                <th class="text-left" style="width:50px;">ID</th>
                <th class="text-left col-md-2">Username</th>
                <th class="text-left col-md-2">Date</th>
                <th class="text-left col-md-2">Status</th>
                <th class="text-left">Notes</th>
                <th class="text-center col-md-1">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $item)
            <tr>
                <td data-title="ID">
                    {{ $item->production_work_order_detail_progress_id }}
                </td>
                <td data-title="Username">
                    {{ $item->production_work_order_detail_progress_created_by }}
                </td>
                <td data-title="Date" class="text-left col-lg-1">
                    {{ $item->production_work_order_detail_progress_date }}
                </td>
                <td data-title="Status" class="text-left col-lg-1">
                    {!! Helper::createStatus(['value' => $item->production_work_order_detail_progress_status,'status' =>
                    $status]) !!}
                </td>
                <td data-title="Notes" class="text-left col-lg-1">
                    {{ $item->production_work_order_detail_progress_notes }}
                </td>
                <td data-title="Delete" class="text-left col-lg-1">
                    <div>
                        @livewire('delete-survey' , $item->production_work_order_detail_progress_id)
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>