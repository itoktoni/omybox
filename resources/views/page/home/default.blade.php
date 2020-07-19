@extends(Helper::setExtendBackend())
@push('css')
<style>
    #transaction {
        font-size: 20px;
        border: 1.4px solid grey;
    }

    #transaction td {
        border: 0.5px solid grey;
        font-size: 18px;
    }

    .even {
        background-color: rgb(247, 245, 234);
    }
</style>
@endpush

@push('javascript')
<script>
    (function worker() {
        var link = "{{ route('home', ['refresh']) }}";
        $.ajax({
            url: link, 
            success: function(data) {
                $('#insert').html(data);
            },
            complete: function() {
                setTimeout(worker, 5000);
            }
        });
    })();
</script>
@endpush
@section('content')
<div class="row">
    <div id="insert" class="panel-body">

    </div>
</div>
@endsection