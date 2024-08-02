<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dirmawa.dashboard') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2">ormawa</span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ Route::currentRouteName() == 'dirmawa.dashboard' ? 'active' : '' }}">
            <a href="{{ route('dirmawa.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div data-i18n="Beranda">Beranda</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Proposal</span></li>
        <li class="menu-item {{ Route::currentRouteName() == 'dirmawa.proposal.index' ? 'active' : '' }}">
            <a href="{{ route('dirmawa.proposal.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-bookmark"></i>
                <div data-i18n="Pengajuan Proposal">Pengajuan Proposal</div>
            </a>
        </li>
        <li class="menu-header"><span class="menu-header-text"></span></li>
        <li class="menu-item">
            <a href="{{ route('logout') }}" class="menu-link" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-power-off"></i>
                <div data-i18n="Logout">Logout</div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </a>
        </li>
    </ul>
</aside>
