@extends(Helper::setExtendFrontend())

@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js">
</script>
@endpush

@section('content')
<section class="ftco-section">
    <div class="container">
        <div class="row no-gutters justify-content-center mb-5 pb-2">
            <div class="col-md-12 text-center heading-section ftco-animate">
                <h2 class="master-header mb-4">My Profile</h2>
                <h4 class="child-header"><a href="{{ route('myaccount') }}">All List Order</a></h4>
            </div>
        </div>
        <div class="row no-gutters">

            <div class="col-md-12 text-center">
                @if(session()->has('success'))
                <div style="margin-top:-20px;" class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Data Berhasil di Update !</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>

            <div class="col-md-12 col-lg-12">
                <div class="row no-gutters justify-content-center mb-5 pb-2">
                    <div class="col-md-12 text-center heading-section ftco-animate">
                        <div class="menus cart-list d-sm-flex ftco-animate align-items-stretch">

                            <div id="billing" class="col-lg-12">
                                <div class="container">

                                    @if ($errors)
                                    @foreach ($errors->all() as $error)
                                    <div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ $error }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </strong>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>


                                {!!Form::open(['route' => 'userprofile', 'class' => 'checkout-form', 'files' => true])
                                !!}
                                <div class="row address-inputs">
                                    <div class="col-md-6">
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-right">
                                                Nama Lengkap
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <input class="form-control {{ $errors->has('name') ? 'error' : ''}}"
                                                    name="name" type="text"
                                                    value="{{ old('name') ?? Auth::user()->name ?? '' }}"
                                                    placeholder="Nama Lengkap">

                                                {!! $errors->first('name', '<p class="help-block">
                                                    :message
                                                </p>
                                                ') !!}
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-right">
                                                Alamat Email
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <input class="form-control {{ $errors->has('email') ? 'error' : ''}}"
                                                    name="email" type="email"
                                                    value="{{ old('email') ?? Auth::user()->email ?? '' }}"
                                                    placeholder="Alamat Email">

                                                {!! $errors->first('email', '<p class="help-block">
                                                    :message
                                                </p>
                                                ') !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 text-right">
                                                Password
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <input class="form-control {{ $errors->has('password') ? 'error' : ''}}"
                                                    name="password" type="password" value="{{ old('password') ?? '' }}"
                                                    placeholder="Ganti Password">

                                                {!! $errors->first('password', '<p class="help-block">
                                                    :message
                                                </p>
                                                ') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-right">
                                                No. Handphone
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <input class="form-control {{ $errors->has('phone') ? 'error' : ''}}"
                                                    name="phone" type="text"
                                                    value="{{ old('phone') ?? Auth::user()->phone ?? '' }}"
                                                    placeholder="Nomer Handphone">

                                                {!! $errors->first('phone', '<p class="help-block">
                                                    :message
                                                </p>
                                                ') !!}
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-right">
                                                Alamat Pengiriman
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <textarea class="form-control" name="address"
                                                    rows="4">{{ old('address') ?? Auth::user()->address ?? '' }}</textarea>

                                                {!! $errors->first('address', '<p class="help-block">
                                                    :message
                                                </p>
                                                ') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-info">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {!! Form::close() !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection

@push('javascript')
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
		$('#force-responsive').DataTable();
	});
</script>
@endpush

@push('css')

<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>
    #force-responsive_wrapper {
        width: 100%;
    }

    #force-responsive_filter input {
        border: 0.5px solid #ced4da;
    }

    @media screen and (max-width: 520px) {
        table {
            width: 100% !important;
        }

        #force-responsive thead {
            display: none;
        }

        #force-responsive td {
            display: block;
            text-align: right;
            border-right: 1px solid #e1edff;
        }

        #force-responsive td::before {
            float: left;
            text-transform: uppercase;
            font-weight: bold;
            content: attr(data-header);
        }

        #force-responsive tr td:last-child {
            border-bottom: 2px solid #dddddd;
        }
    }
</style>
@endpush