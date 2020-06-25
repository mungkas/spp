<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg order-lg-first">
               <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                @if(Auth::user()->role == 'Pegawai' || Auth::user()->role == 'Admin' )
                    <li class="nav-item">
                        <a href="{{ route('web.index') }}" class="nav-link {{ set_active(['web.*'], 'active') }}">
                            <i class="fe fe-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('spp.index') }}" class="nav-link {{ set_active(['spp.*'], 'active') }}">
                            <i class="fe fe-shopping-cart"></i> Transaksi SPP
                        </a>
                    </li>                   
                    <li class="nav-item">
                        <a href="{{ route('keuangan.index') }}" class="nav-link {{ set_active(['keuangan.*'], 'active') }}">
                            <i class="fe fe-repeat"></i> Keuangan
                        </a>
                    </li>
                    @endif
                                    
                    @if(Auth::user()->role == 'Admin')
                    <li class="nav-item">
                        <a href="{{ route('tagihan.index') }}" class="nav-link {{ set_active(['tagihan.*'], 'active') }}">
                            <i class="fe fe-credit-card"></i> Tagihan
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->role == 'TU' || Auth::user()->role == 'Admin')
                    <li class="nav-item">
                        <a href="{{ route('siswa.index') }}" class="nav-link {{ set_active(['siswa.*'], 'active') }}">
                            <i class="fe fe-user"></i> Siswa
                        </a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kelas.index') }}" class="nav-link {{ set_active(['kelas.*'], 'active') }}">
                            <i class="fe fe-users"></i> Kelas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jenjang.index') }}" class="nav-link {{ set_active(['jenjang.*'], 'active') }}">
                            <i class="fe fe-box"></i>Jenjang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('periode.index') }}" class="nav-link {{ set_active(['periode.*'], 'active') }}">
                            <i class="fe fe-box"></i> Periode
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->role == 'Admin')
                    <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link {{ set_active(['user.*'], 'active') }}">
                            <i class="fe fe-user-plus"></i> Pengguna
                        </a>
                    </li>
                   @endif

                </ul>
            
            </div>
        </div>
    </div>
</div>