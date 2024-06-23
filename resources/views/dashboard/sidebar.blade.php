<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark overflow-hidden" style="width: 300px;">
    <div id="sidebarDate">
        <div class="clock-sidebar"></div>
        <div class="date-sidebar"></div>
    </div>
    <hr>
    <a href="/" class="d-flex gap-2 justify-content-center align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <div class="d-flex gap-2 align-items-center">
            <img src="/images/favicons/android-chrome-512x512.png" alt="Logo STMIK Bandung" class="bi pe-none me-2" width="90">
            <div class="flex-column">
                <h1 class="fs-5 fw-semibold mb-0">STMIK Bandung</h1>
                <span>Access Control Level</span>
            </div>
        </div>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto mt-3">
        <li>
            <a
                href="/home"
                class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('home') ? 'active' : '' }}"
            >
                <i data-feather="home" style="width: 1.2em"></i>
                Home
            </a>
        </li>
        <li class="mb-1" id="sidebarDropdown">
            <button class="nav-link text-white d-flex align-items-center gap-2 collapsed w-100 {{ Request::is('users/*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="true">
                <i data-feather="users" style="width: 1.2em"></i>
                Users
            </button>
            <div class="collapse" id="dashboard-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                    <li>
                        <a href="/users/admin" class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('users/admin') ? 'active' : '' }}">
                            Admin
                        </a>
                    </li>
                    <li>
                        <a href="/users/dosen" class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('users/dosen') ? 'active' : '' }}">
                            Dosen
                        </a>
                    </li>
                    <li>
                        <a href="/users/karyawan" class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('users/karyawan') ? 'active' : '' }}">
                            Karyawan
                        </a>
                    </li>
                    <li>
                        <a href="/users/mahasiswa" class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('users/mahasiswa') ? 'active' : '' }}">
                            Mahasiswa
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a
                href="/accesses"
                class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('accesses') ? 'active' : '' }}"
            >
                <i data-feather="check-square" style="width: 1.2em"></i>
                Accesses
            </a>
        </li>
        <li>
            <a
                href="/account"
                class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('account') ? 'active' : '' }}"
            >
                <i data-feather="settings" style="width: 1.2em"></i>
                My Account
            </a>
        </li>
    </ul>
    <hr>
    <form action="/logout"">
        @csrf
        <button class="btn btn-dark d-flex gap-1 w-100 align-items-center justify-content-center" type="submit" id="buttonSignout">
            <i data-feather="log-out" style="width: 1.2em"></i>
            <span>
                Logout
            </span>
        </button>
    </form>
</div>
