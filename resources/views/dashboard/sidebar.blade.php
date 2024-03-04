<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 300px;">
    <a href="/" class="d-flex gap-2 justify-content-center align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4 fw-bold">STMIK Bandung - ACL</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li>
            <a
                href="/home"
                class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('home') ? 'active' : '' }}"
            >
                <i data-feather="home" style="width: 1.2em"></i>
                Home
            </a>
        </li>
        <li>
            <a
                href="/users"
                class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('users') ? 'active' : '' }}"
            >
                <i data-feather="users" style="width: 1.2em"></i>
                Manage Users
            </a>
        </li>
        <li>
            <a
                href="/user-access"
                class="nav-link text-white d-flex align-items-center gap-2 {{ Request::is('user-access') ? 'active' : '' }}"
            >
                <i data-feather="check-square" style="width: 1.2em"></i>
                Manage User Access
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
