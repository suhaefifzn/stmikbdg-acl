@extends('dashboard.main')
@section('dashboard_content')
<div class="container">
    <div class="col-lg-6 p-3">
        <form class="d-flex flex-column" method="post" id="formChangeData">
            <input type="hidden" name="token_change_data" value="{{ csrf_token() }}">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" class="form-text" disabled value="{{ old('name', session('profile')['nama']) }}">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" class="form-text" value="{{ old('email', session('user_email')) }}">
            </div>
            <div class="d-flex flex-column gap-2 mt-3">
                <button type="button" class="btn btn-primary d-flex gap-2 justify-content-center align-items-center" id="buttonSave">
                    <i data-feather="save" style="width: 1.2em"></i>
                    Save
                </button>
                <button type="button" class="btn btn-secondary d-flex gap-2 justify-content-center align-items-center" id="buttonChangePassword">
                    <i data-feather="lock" style="1.2em"></i>
                    Change Password
                </button>
            </div>
        </form>
    </div>
</div>

{{-- modal update password --}}
<div class="modal fade" id="modalChangePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="modalChangePasswordLabel">
                <i data-feather="lock" style="width: 1em;"></i>
                Change Password
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form method="post" class="overflow-y-scroll" id="formChangePassword">
                <input type="hidden" name="token_change_password" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="password" class="form-label">Current password</label>
                        <input type="password" class="form-control form-control-sm" name="password" id="password">
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New password</label>
                        <input type="password" class="form-control form-control-sm" name="new_password" id="newPassword">
                    </div>
                    <div class="mb-3">
                        <label for="re_enter_new_password" class="form-label">Re-enter new password</label>
                        <input type="password" class="form-control form-control-sm" name="re_enter_new_password" id="reEnterNewPassword">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="buttonSubmitChangePassword">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        $('#buttonSave').on('click', (event) => {
            event.preventDefault();

            $('.error-message').remove();

            const formData = {
                _token: $('input[name="token_change_data"]').val(),
                name: $('#name').val(),
                username: $('#username').val(),
                email: $('#email').val(),
            };

            $.ajax({
                url: '/account/update',
                type: 'POST',
                data: formData,
                cache: false,
                success: (response, status, xhr) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        toast: true,
                        showConfirmButton: false,
                        timerProgressBar: true,
                        timer: 3000,
                        position: 'top-right',
                    });
                },
                error: (xhr, status) => {
                    if (xhr.status == 422) {
                        const { errors } = xhr.responseJSON;

                        $.each(errors, (key, value) => {
                            $(`#${key}`).after(
                                `<div class="error-message text-danger small">${value}</div>
                            `);
                        });
                    } else {
                        console.log(xhr);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Oops, something wrong. Text Admin.'
                        });
                    }
                }
            })
        });

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
                password: $('#password').val(),
                new_password: $('#newPassword').val(),
                re_enter_new_password: $('#reEnterNewPassword').val(),
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
                            title: 'Success!',
                            text: response.message,
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

                        $.each(errors, (key, value) => {
                            $(`input[name="${key}"]`).after(
                                `<div class="error-message text-danger small">${value}</div>`
                            );
                        });
                    } else if (xhr.status == 404) {
                        $('#formChangePassword #password').after(
                            `<div class="error-message text-danger small">Current passsword does not match our records</div>`
                        );
                    } else {
                        console.log(xhr);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Oops, something wrong. Contact your IT Support'
                        });
                    }
                },
            });
        });
    });
</script>
@endsection
