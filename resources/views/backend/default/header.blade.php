<header class="header">
    <div class="logo-container">
        <div onclick="window.open('{{ URL::to('/') }}','_blank');" href="{{ url('/') }}" target="_blank" class="logo"><img
                src="{{ Helper::asset('/files/logo') }}/{{ config('website.logo','default_favicon.png') }}"
                style="height: 45px;margin-left: 0px;cursor:pointer" alt="{{ config('app.name') }}" />
        </div>
        <div id="leftMenu" class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened"
            data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>
    <div class="header-right">
        <ul class="notifications">
            <li>
                <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown"><i
                        class="fa fa-tasks"></i><span class="badge">3</span>
                </a>
                <div class="dropdown-menu notification-menu large">
                    <div class="notification-title">
                        <span class="pull-right label label-default">3</span>Tasks
                    </div>
                    <div class="content">
                        <ul>
                            <li>
                                <p class="clearfix mb-xs">
                                    <span class="message pull-left">Generating Sales Report</span>
                                    <span class="message pull-right text-dark">60%</span>
                                </p>
                                <div class="progress progress-xs light">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                        aria-valuemax="100" style="width: 60%;"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                    <i class="fa fa-envelope"></i>
                    <span class="badge">4</span>
                </a>
                <div class="dropdown-menu notification-menu">
                    <div class="notification-title">
                        <span class="pull-right label label-default">230</span>
                        Messages
                    </div>
                    <div class="content">
                        <ul>
                            <li>
                                <a href="#" class="clearfix">
                                    <figure class="image">
                                        <img src="{{ Helper::files('profile/sample_user.jpg') }}"
                                            alt="Joseph Doe Junior" class="img-circle" />
                                    </figure>
                                    <span class="title">Joseph Doe</span>
                                    <span class="message">Lorem ipsum dolor sit.</span>
                                </a>
                            </li>
                        </ul>
                        <hr />
                        <div class="text-right">
                            <a href="#" class="view-more">View All</a>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    <span class="badge">3</span>
                </a>
                <div class="dropdown-menu notification-menu">
                    <div class="notification-title">
                        <span class="pull-right label label-default">3</span>
                        Alerts
                    </div>
                    <div class="content">
                        <ul>
                            <li>
                                <a href="#" class="clearfix">
                                    <div class="image">
                                        <i class="fa fa-thumbs-down bg-danger"></i>
                                    </div>
                                    <span class="title">Server is Down!</span>
                                    <span class="message">Just now</span>
                                </a>
                            </li>
                        </ul>
                        <hr />
                        <div class="text-right">
                            <a href="#" class="view-more">View All</a>
                        </div>
                    </div>
                </div>
            </li>
            <li style="border-left: 1px solid grey;padding-left: 10px;">
                <a id="rightMenu" href="#" style="border:none;background-color: #191c21;color:white;"
                    class="sidebar-right-toggle notification-icon" data-open="sidebar-right">
                    <i style="color: white;" class="fa fa-folder-open"></i>
                </a>
            </li>
        </ul>
        <span class="separator"></span>
        <div id="userbox" class="userbox">
            <a href="#" data-toggle="dropdown">
                <figure class="profile-picture">
                    @auth
                    @if(empty(Auth::user()->photo))
                    <img src="{{ Helper::files('profile/default_profile.png') }}" alt="{{ Auth::user()->name }}"
                        class="img-circle" }}" />
                    @else
                    <img src="{{ Helper::files('profile/'.Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" />
                    @endif
                    @endauth
                </figure>
                <div class="profile-info">
                    <span class="name">@auth{{ Auth::user()->username }}@endauth</span>
                    <span class="role">@auth{{ Auth::user()->group_user }}@endauth</span>
                </div>
                <i class="fa custom-caret"></i>
            </a>
            <div class="dropdown-menu">
                <ul class="list-unstyled">
                    @auth
                    @if( config('website.developer_setting') == Auth::user()->group_user)
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{ route('console') }}"><i class="fa fa-terminal"></i>
                            &nbsp; System Console</a>
                    </li>
                    @endif
                    @if( config('website.developer_setting') == Auth::user()->group_user ||
                    config('website.menu_setting') == Auth::user()->group_user)
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{ route('configuration') }}"><i
                                class="fa fa-wrench"></i> &nbsp; System Setting</a>
                    </li>
                    @endif
                    @if( config('website.developer_setting') == Auth::user()->group_user ||
                    config('website.menu_setting') ==
                    Auth::user()->group_user)
                    <li>
                        <div role="menuitem" tabindex="-1" class="header-menu"
                            onclick="location.href ='{{ route('route') }}';">
                            <i class="fa fa-list-alt"></i> &nbsp;
                            List Routes</div>
                    </li>
                    @endif
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{ route('profile') }}">&nbsp;<i class="fa fa-user"></i>
                            &nbsp;&nbsp;&nbsp;My Profile</a>
                    </li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{ route('resetpassword') }}">&nbsp;<i
                                class="fa fa-lock"></i>
                            &nbsp;&nbsp; Reset Password</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <div id="logout" class="header-menu" role="menuitem" tabindex="-1"
                            onclick="location.href ='{{ route('reset') }}';">&nbsp;<i class="fa fa-power-off"></i>
                            &nbsp;
                            Logout</div>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</header>