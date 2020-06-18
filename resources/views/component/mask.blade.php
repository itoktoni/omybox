@push('js')
<script src="{{ Helper::backend('vendor/mask/cleave.min.js') }}"></script>
<script src="{{ Helper::backend('vendor/mask/numeral.min.js') }}"></script>
@endpush
@push('javascript')
<script>
    function maskNumber() {
        $('.number').toArray().forEach(function (field) {
            new Cleave(field, {
                numeral: true,
                numeralDecimalMark: '.',
                delimiter: ',',
                numeralDecimalScale: 4
            });
        });
    }

    function maskMoney() {
        $('.money').toArray().forEach(function (field) {
            new Cleave(field, {
            numeral: true,
                numeral: true,
                delimiter: ',',
                numeralDecimalScale: 0
            });
        });
    }

    $(document).ready(function() {

    @if(in_array('number', $array))
        maskNumber();
    @endif
    
    @if(in_array('money',$array))
       maskMoney();
    @endif
    
    @if(in_array('date',$array))
        var cleave = new Cleave('.date', {
            date: true,
            delimiter: '-',
            datePattern: ['Y', 'm', 'd']
        });
    @endif

});
</script>
@endpush