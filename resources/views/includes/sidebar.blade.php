<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="
            @if(auth()->user()->roles === 'admin')
                {{ route('admin.dashboard') }}
            @elseif(auth()->user()->roles === 'mahasiswa')
                {{ route('mahasiswa.dashboard') }}
            @elseif(auth()->user()->roles === 'dosen')
                {{ route('dosen.dashboard') }}
            @endif
        " class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2">ormawa</span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @php
            $subMenuRoutes = ['admin.mahasiswa.index', 'admin.dosen.index', 'admin.dirmawa.index'];
            $isSubMenuActive = in_array(Route::currentRouteName(), $subMenuRoutes);
        @endphp
        <li class="menu-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div data-i18n="Beranda">Beranda</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Pengguna</span></li>
        <li class="menu-item {{ $isSubMenuActive ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Pengguna">Pengguna</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::currentRouteName() == 'admin.mahasiswa.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.mahasiswa.index') }}" class="menu-link">
                        <div data-i18n="Mahasiswa">Mahasiswa</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::currentRouteName() == 'admin.dosen.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.dosen.index') }}" class="menu-link">
                        <div data-i18n="Dosen">Dosen Pembimbing</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::currentRouteName() == 'admin.dirmawa.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.dirmawa.index') }}" class="menu-link">
                        <div data-i18n="Dirmawa">Dirmawa</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Proposal</span></li>
        <li class="menu-item {{ Route::currentRouteName() == 'admin.proposal.index' ? 'active' : '' }}">
            <a href="{{ route('admin.proposal.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-bookmark"></i>
                <div data-i18n="Pengajuan Proposal">Pengajuan Proposal</div>
            </a>
        </li>
        <li class="menu-item {{ Route::currentRouteName() == 'admin.proposal.arsip' ? 'active' : '' }}">
            <a href="{{ route('admin.proposal.arsip') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-history"></i>
                <div data-i18n="Arsip Proposal">Arsip Proposal</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Agenda Kegiatan</span></li>
        <li class="menu-item {{ Route::currentRouteName() == 'admin.agenda.index' ? 'active' : '' }}">
            <a href="{{ route('admin.agenda.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div data-i18n="Agenda">Agenda</div>
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
