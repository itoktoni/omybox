@extends(Helper::setExtendBackend())
@component('component.date', ['array' => ['date']])

@endcomponent
@section('content')
<div class="row">
    <div class="panel-body">
        {!! Form::open(['route' => 'profile', 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="panel panel-default">
            <header class="panel-heading">
                <h2 class="panel-title">Profile ( {{ Auth::user()->name }} )</h2>
            </header>

            <div class="panel-body line">
                <div class="col-md-12 col-lg-12">

                    <div class="col-md-4 col-lg-3">
                        <section class="panel">
                            <div class="">
                                <div class="text-center">
                                    @if(Auth::user()->photo == '')
                                    <img src="{{ asset('public/files/profile/default_profile.png') }}"
                                        class="img-thumbnail rounded center-block img-responsive" alt="no profile">
                                    @else
                                    <img src="{{ Helper::files('profile/'.Auth::user()->photo) }}"
                                        class="img-thumbnail rounded center-block img-responsive" alt="John Doe">
                                    @endif
                                </div>
                            </div>
                        </section>

                        <h5 class="text-center">Logo : <code> W : 200px & H : 200px </code></h5>
                        <hr class="dotted short">

                        <div class="col-md-12 space">
                            <section class="panel">
                                <input type="file" name="gambar" class="btn btn-default btn-sm btn-block">
                            </section>
                        </div>

                    </div>

                    <div class="col-md-8 col-lg-9">

                        <div class="panel-group" id="accordion">
                            <div class="panel panel-accordion">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                            href="#collapse1One">
                                            Information
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse1One" class="accordion-body collapse in">
                                    <div class="panel-body line">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Name</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                                                        required="" class="form-control">
                                                </div>

                                                <label class="col-md-2 control-label">Email</label>
                                                <div class="col-md-4">
                                                    <input type="text" required="" value="{{ Auth::user()->email }}"
                                                        name="email" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Date</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" name="birth"
                                                            value="{{ Auth::user()->birth }}" class="date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <label class="col-md-2 control-label">Place</label>
                                                <div class="col-md-4">
                                                    <input type="text" value="{{ Auth::user()->place_birth }}"
                                                        name="place_birth" class="form-control">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-accordion">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                            href="#address">
                                            Address
                                        </a>
                                    </h4>
                                </div>
                                <div id="address" class="accordion-body collapse">
                                    <div class="panel-body line">
                                        <div class="col-md-12">
                                            <textarea class="form-control" name="address"
                                                rows="2">{{ Auth::user()->address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-accordion">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                            href="#collapse1Two">
                                            Description
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse1Two" class="accordion-body collapse">
                                    <div class="panel-body line">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Gender</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="gender">
                                                        <option
                                                            {{ Auth::user()->gender == 'Male' ? 'selected=selected' : '' }}
                                                            value="Male">Male</option>
                                                        <option
                                                            {{ Auth::user()->gender == 'Female' ? 'selected=selected' : '' }}
                                                            value="Female">Female</option>
                                                    </select>
                                                </div>

                                                <label class="col-md-2 control-label">Phone</label>
                                                <div class="col-md-4">
                                                    <input type="text" value="{{ Auth::user()->handphone }}"
                                                        name="handphone" class="form-control">
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">NPWP</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="no_tax" value="{{ Auth::user()->no_tax }}"
                                                        class="form-control">
                                                </div>

                                                <label class="col-md-2 control-label">NIK</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="nik" value="{{ Auth::user()->nik }}"
                                                        class="form-control">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-accordion">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                            href="#collapse1Three">
                                            Group
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse1Three" class="accordion-body collapse">
                                    <div class="panel-body line">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Site</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="site_id" readonly=""
                                                        value="{{ Auth::user()->site_id }}" class="form-control">
                                                </div>

                                                <label class="col-md-2 control-label">Group</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="group_user" readonly=""
                                                        value="{{ Auth::user()->group_user }}" class="form-control">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-accordion">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                            href="#collapse1Four">
                                            Note
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse1Four" class="accordion-body collapse">
                                    <div class="panel-body line">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control basic" name="biografi"
                                                    rows="3">{{ Auth::user()->biografi }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="navbar-fixed-bottom" id="menu_action">
                <div class="text-right" style="padding:5px">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection