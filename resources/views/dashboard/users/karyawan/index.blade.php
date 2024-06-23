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
            <li class="breadcrumb-item">
                <span class="link-body-emphasis fw-semibold text-decoration-none">Users</span>
              </li>
            <li class="breadcrumb-item active" aria-current="page">
                Karyawan
            </li>
        </ol>
    </nav>
</div>
@endsection
@section('content')
<div class="p-">
    <p>
        Belum difungsikan.
    </p>
</div>
@endsection
@section('scripts')

@endsection
