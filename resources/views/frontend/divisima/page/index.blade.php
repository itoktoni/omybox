@extends(Helper::setExtendFrontend())

@section('content')
    @include(Helper::setExtendFrontend('homepage.slider', true))
    @include(Helper::setExtendFrontend('homepage.latest', true))
    @include(Helper::setExtendFrontend('homepage.bestseller', true))
@endsection