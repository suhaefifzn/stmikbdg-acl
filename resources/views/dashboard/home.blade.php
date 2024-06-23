@extends('dashboard.main')
@section('breadcrumbs')
<div class="container pt-3 my-2 shadow-sm bg-body-tertiary rounded border-bottom border-top border-dark">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-chevron bg-body-tertiary rounded-3">
            <li class="breadcrumb-item">
                <a class="link-body-emphasis" href="/">
                    <svg class="bi" width="16" height="16"><use xlink:href="#house-door-fill"></use></svg>
                    <span class="visually-hidden">Home</span>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Home
            </li>
        </ol>
    </nav>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-3">
        <a class="card text-decoration-none" href="/users/admin">
            <div class="card-img-wrapper">
                <img src="/images/admin.png" class="card-img-top" alt="Admin">
            </div>
            <div class="card-body">
                <h5 class="card-title">Admin</h5>
                <p class="card-text">Total: {{ $data['total_akun_admin'] }}</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a class="card text-decoration-none" href="/users/dosen">
            <div class="card-img-wrapper">
                <img src="/images/professor.png" class="card-img-top" alt="Moderator">
            </div>
            <div class="card-body">
                <h5 class="card-title">Dosen</h5>
                <p class="card-text">Total: {{ $data['total_akun_dosen'] }}</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a class="card text-decoration-none" href="/users/karyawan">
            <div class="card-img-wrapper">
                <img src="/images/admin3.png" class="card-img-top" alt="Subscriber">
            </div>
            <div class="card-body">
                <h5 class="card-title">Karyawan</h5>
                <p class="card-text">Total: {{ $data['total_akun_staff'] }}</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a class="card text-decoration-none" href="/users/mahasiswa">
            <div class="card-img-wrapper">
                <img src="/images/student.png" class="card-img-top" alt="Author">
            </div>
            <div class="card-body">
                <h5 class="card-title">Mahasiswa</h5>
                <p class="card-text">Total: {{ $data['total_akun_mahasiswa'] }}</p>
            </div>
        </a>
    </div>
</div>
@endsection
