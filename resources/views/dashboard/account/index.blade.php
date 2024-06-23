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
                My Account
            </li>
        </ol>
    </nav>
</div>
@endsection
@section('content')
<div class="col-lg-5 px-3">
    <form class="d-flex flex-column" method="post" id="formChangeData">
        <input type="hidden" name="token_change_data" value="{{ csrf_token() }}">
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" class="form-text" disabled value="{{ old('name', session('profile')['nama']) }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" class="form-text" value="{{ old('email', session('user_email')) }}" disabled>
        </div>
        <div class="d-flex flex-column gap-2 mt-3">
            <button type="button" class="btn btn-secondary d-flex gap-2 justify-content-center align-items-center" id="buttonChangePassword">
                <i data-feather="lock" style="1.2em"></i>
                Change Password
            </button>
        </div>
    </form>
</div>

{{-- modal update password --}}
<div class="modal fade" id="modalChangePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="modalChangePasswordLabel">
                <i data-feather="lock" style="width: 1em;"></i>
                Ubah Password
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form method="post" id="formChangePassword">
                <input type="hidden" name="token_change_password" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="passwordSekarang" class="form-label">Password Sekarang</label>
                        <input type="password" class="form-control form-control-sm" name="password_sekarang" id="passwordSekarang">
                    </div>
                    <div class="mb-3">
                        <label for="passwordBaru" class="form-label">Password Baru</label>
                        <input type="password" class="form-control form-control-sm" name="password_baru" id="passwordBaru">
                    </div>
                    <div class="mb-3">
                        <label for="konfirmasiPasswordBaru" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control form-control-sm" name="konfirmasi_password_baru" id="konfirmasiPasswordBaru">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="buttonSubmitChangePassword">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(() => {
        $('#buttonChangePassword').on('click', (event) => {
            event.preventDefault();
            $('#formChangePassword .error-message').remove();
            $('#modalChangePassword').modal('show');
        });

        $('#formChangePassword').submit((event) => {
            event.preventDefault();

            $('#formChangePassword .error-message').remove();

            const formData = {
                _token: $('input[name="token_change_password"]').val(),
                password_sekarang: $('#passwordSekarang').val(),
                password_baru: $('#passwordBaru').val(),
                konfirmasi_password_baru: $('#konfirmasiPasswordBaru').val(),
            };

            $.ajax({
                url: '/account/password/update',
                type: 'POST',
                data: formData,
                cache: false,
                success: (response, status, xhr) => {
                    if (xhr.status == 200 ) {
                        Swal.fire({
                            icon: 'success',
                            text: 'Password berhasil diubah. Mohon login ulang',
                            toast: true,
                            timerProgressBar: true,
                            timer: 1500,
                            showConfirmButton: false,
                            position: 'top-right',
                        }).then(() => {
                            $('#buttonSignout').trigger('click');
                        });
                    } else {
                        console.log(xhr);
                    }
                },
                error: (xhr, status) => {
                    if (xhr.status == 422) {
                        const { errors } = xhr.responseJSON;

                        console.log(xhr);

                        $.each(errors, (key, value) => {
                            $(`input[name="${key}"]`).after(
                                `<div class="error-message text-danger small">${value}</div>`
                            );
                        });
                    } else if (xhr.status == 404) {
                        $('#formChangePassword #passwordSekarang').after(
                            `<div class="error-message text-danger small">Current passsword does not match our records</div>`
                        );
                    } else {
                        console.log(xhr);

                        Swal.fire({
                            icon: 'error',
                            text: 'Oops, something wrong. Contact your IT Support',
                            timer: 3000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-right',
                        });
                    }
                },
            });
        });
    });
</script>
@endsection
