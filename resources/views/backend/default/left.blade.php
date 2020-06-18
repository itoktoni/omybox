<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header" style="border-bottom: 0.1px solid grey;">
        <div href="{{ route('home') }}" onclick="location.href ='{{ route('home') }}';" style="color:white;text-decoration: none;z-index: 999;">
            <div class="sidebar-title">
                <i style="margin-left:8px;font-size: 25px;margin-right: 7px;color:#ABB4BE;" class="fa fa-home" aria-hidden="true"></i>
                <span class="text-center" style="font-size: 13px;color:#ABB4BE;">Dashboard</span>
            </div>
        </div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>
    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul id="left" class="nav nav-main">
                    @if(isset($menu_list))
                    @foreach ($menu_list as $menu)
                    @if($menu->module_single == "1")
                    <li>
                        <a id="linkMenu" href="{{ $menu->module_link }}">
                            <!--<span class="pull-right label label-primary">182</span>-->
                            <i class="fa fa-external-link" aria-hidden="true"></i>
                            <span>{{ $menu->module_name }} </span>
                        </a>
                    </li>
                    @else
                    @if($menu->module_visible == '1' && $menu->module_enable == '1')
                    <li class="nav-parent {{ $module === $menu->action_module ? 'nav-expanded nav-active' : '' }}">
                        <a id="linkMenu">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span class="text-capitalize"> {{ $menu->module_name }}</span>
                        </a>
                        <ul class="nav nav-children">
                            @foreach ($action_list as $data_action)
                            @if($menu->module_code === $data_action->module_code && $data_action->action_visible == '1')
                            <li {{ $action_code == $data_action->action_code ? " class=nav-active" : '' }}>
                                <a id="childMenu" href="{!! route("$data_action->action_code") !!}">
                                    {{ $data_action->action_name }}
                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endif
                    @endforeach
                    @endif
                </ul>
            </nav>
            <hr class="separator" />
        </div>
    </div>
</aside>