@push('style')
    <style>
        @media (min-width: 320px) and (max-width: 767px){
@foreach($array as $key => $value)
        td:nth-of-type({{ $loop->iteration }}):before {content: '{{ $value }}';}
@if ($loop->last)
        td:nth-of-type( {{ $loop->iteration + 1 }} ):before {content: 'Check';}
        td:nth-of-type( {{ $loop->iteration + 2 }} ):before {content: 'Action';}
@endif
@endforeach
        }
    </style>
@endpush