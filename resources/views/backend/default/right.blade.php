<aside id="sidebar-right" class="sidebar-right">
    <div class="panel-header">
        <div class="row">
            <div class="col-md-8">
                <div class="visible-xs logo-container" style="background-color: white;width: 100%;padding:10px;">
                    <a id="linkMenu" href="{{ url('/') }}" target="_blank" class="logo">
                        <img src="{{ Helper::asset('/files/logo') }}/{{ config('website.logo','default_favicon.png') }}" style="height: 45px;" alt="{{ config('app.name') }}" />
                    </a>
                </div>
            </div>
            <div style="position: absolute !important;top: 5px;right: 15px;margin-top:  10px;">
                <div style="border-radius: 50%;width: 40px;height: 40px;" class="visible-xs mobile-close">
                    <i style="color: white;margin-right: 20px;margin-top: -10px;margin-left: -5px;" class="fa fa-close" aria-label="Toggle sidebar"></i>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-top: 0px;" class="nano">
        <div class="nano-content" style="padding:10px 10px 10px 10px;border:none;">
            <nav id="menu" style="border:none;" class="nav-main" role="navigation">
                <div id="right-group" class="list-group">
                    @isset($group_list)
                    @foreach($group_list as $group)
                    <div id="linkMenu" onclick="location.href = '{{ route('access_group',[$group->group_module_code]) }}';" href="{{ route('access_group',[$group->group_module_code]) }}" class="pointer linkRight list-group-item {{ (Session(Auth::User()->username.'_group_access') == $group->group_module_code ? 'active' : '') }}">
                        <span>{{ $group->group_module_name }}</span>
                    </div>
                    @endforeach
                    @endisset
                    @if(isset(Auth::user()->group_user) && Auth::user()->group_user == 'developer')
                    <div id="reboot" style="background-color: #d2312d;border:none;color: white;text-align: right;font-weight: bold;" href="{{ route('reboot') }}" onclick="location.href ='{{ route('reboot') }}';" class="list-group-item">REBOOT</div>
                    @endif
                </div>
            </nav>
        </div>
    </div>
</aside>
