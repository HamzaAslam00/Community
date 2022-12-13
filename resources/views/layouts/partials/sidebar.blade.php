<!-- sidebar @s -->
<div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="/" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ asset('images/logo.png') }}" alt="logo">
                <img class="logo-dark logo-img" src="{{ asset('images/logo-dark.png') }}" alt="logo-dark">
                <img class="logo-small logo-img logo-img-small d-none" src="{{ asset('images/logo-small.png') }}" alt="logo-small">
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em
                    class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em
                    class="icon ni ni-menu"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Dashboard</h6>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('dashboard.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-home-fill"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                            {{-- <span class="nk-menu-badge">HOT</span> --}}
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('groups.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">Groups</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('registration-pages.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-note-add"></em></span>
                            <span class="nk-menu-text">Registration Pages</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('tickets.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-ticket"></em></span>
                            <span class="nk-menu-text">Tickets</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('activation-urls.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-link-alt"></em></span>
                            <span class="nk-menu-text">Activation Urls</span>
                        </a>
                    </li>
                    @can('view_users')
                        <li class="nk-menu-heading">
                            <h6 class="overline-title text-primary-alt">Security</h6>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{ route('users.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                                <span class="nk-menu-text">Users</span>
                            </a>
                        </li>
                    @endcan
                    {{-- <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-layers-fill"></em></span>
                            <span class="nk-menu-text">Ui Elements</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href=javascript:void(0)" class="nk-menu-link"><span
                                        class="nk-menu-text">Typography</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">Utilities</span></a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item"><a href="javascript:void(0)"
                                            class="nk-menu-link"><span class="nk-menu-text">Border</span></a></li>
                                </ul><!-- .nk-menu-sub -->
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li> --}}
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->