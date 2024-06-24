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
                Mahasiswa
            </li>
        </ol>
    </nav>
</div>
@endsection
@section('content')
{{-- Button add user --}}
<div class="my-3">
    <button class="btn btn-primary d-flex gap-1 align-items-center" id="buttonModalAddUser">
        <i data-feather="plus" width="1em"></i>
        <span>Tambah Akun Mahasiswa</span>
    </button>
</div>

{{-- Table --}}
<div class="row p-3">
    {{-- Table --}}
    <div class="table-wrapper">
        <table id="myTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th style="text-align: left;">No</th>
                    <th style="text-align: left;">NIM</th>
                    <th>Email</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['list_mahasiswa'] as $user)
                    @php
                        $kdUser = explode('-', $user['kd_user'])[1];
                    @endphp
                    <tr>
                        <td style="text-align: left;">{{ $loop->iteration }}</td>
                        <td style="text-align: left;">{{ $kdUser }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="badge bg-warning border-0" title="Edit" data-user="{{ $user['id'] }}" data-token="{{ csrf_token() }}" onclick="editUser(this)">
                                    <i data-feather="edit" style="width: 1.3em"></i>
                                </button>
                                <button class="badge bg-danger border-0" title="Delete" data-user="{{ $user['id'] }}" data-token="{{ csrf_token() }}" onclick="deleteUser(this)">
                                    <i data-feather="x-circle" style="width: 1.3em"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- modal add user --}}
<div class="modal fade" id="modalAddUser" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="modalAddUserLabel">
                <i data-feather="plus" style="width: 1.3em;"></i>
                Tambah Akun Mahasiswa
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form method="post" action="/users/mahasiswa/add" id="formAddUser">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="kd_user" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="off" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal edit user --}}
<div class="modal fade" id="modalEditUser" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="modalEditUserLabel">
                <i data-feather="edit" style="width: 1.3em;"></i>
                Edit User
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form id="formEditUser">
                @csrf
                @method('put')
                <div class="modal-body">
                    <input type="hidden" name="userIdEdit" id="userIdEdit">
                    <div class="mb-3">
                        <label for="nimEdit" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nimEdit" name="kd_user" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailEdit" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailEdit" name="email" autocomplete="off" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(() => {
        $('#myTable').dataTable({
            'pageLength': 5,
            'lengthMenu': [[5, 10, 15, -1], [5, 10, 15, 'All']],
            'ordering': false,
        });

        // Open modal add user
        $('#buttonModalAddUser').on('click', (e) => {
            e.preventDefault();
            $('#formAddUser .error-message').remove();
            $('#modalAddUser').modal('show');
        });

        // Add new user
        $('#formAddUser').on('submit', (e) => {
            e.preventDefault();
            $('#formAddUser .error-message').remove();

            const data = {
                _token: $('#formAddUser input[name="_token"]').val(),
                kd_user: $('#formAddUser #nim').val(),
                email: $('#formAddUser #email').val(),
                password: $('#formAddUser #password').val(),
            };

            $.ajax({
                url: '/users/mahasiswa/add',
                type: 'POST',
                data,
                beforeSend: () => {
                    $.LoadingOverlay('show');
                },
                success: (response, status, xhr) => {
                    $.LoadingOverlay('hide');
                    Swal.fire({
                        icon: 'success',
                        text: 'Akun mahasiswa berhasil ditambahkan',
                        toast: true,
                        timerProgressBar: true,
                        timer: 1500,
                        showConfirmButton: false,
                        position: 'top-right',
                    }).then(() => {
                        location.reload();
                    })
                },
                error: (xhr, status) => {
                    $.LoadingOverlay('hide');
                    console.log(xhr);

                    if (xhr.status === 400) {
                        Swal.fire({
                            icon: 'warning',
                            text: xhr.responseJSON.message,
                            timer: 3000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-right',
                        });
                    } else if (xhr.status === 422) {
                        const { errors } = xhr.responseJSON;

                        $.each(errors, (key, value) => {
                            if (key === 'email' || key === 'password' || key === 'kd_user') {
                                if (key === 'kd_user') {
                                    $(`#formAddUser .error-kd-user`).html(
                                        `<div class="error-message text-danger small">${value}</div>`
                                    );
                                } else {
                                    $(`#formAddUser input[name="${key}"]`).after(
                                        `<div class="error-message text-danger small">${value}</div>`
                                    );
                                }
                            }
                        });
                    } else {
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
                }
            })
        });

        // edit user
        $('#formEditUser').on('submit', (e) => {
            e.preventDefault();
            $('#formEditUser .error-message').remove();

            const data = {
                _token: $('#formEditUser input[name="_token"]').val(),
                _method: $('#formEditUser input[name="_method]').val(),
                user_id: $('#formEditUser #userIdEdit').val(),
                kd_user: $('#formEditUser #nimEdit').val(),
                email: $('#formEditUser #emailEdit').val()
            };

            $.ajax({
                url: '/users/mahasiswa/update',
                type: 'PUT',
                data,
                beforeSend: () => {
                    $.LoadingOverlay('show');
                },
                success: (response, status, xhr) => {
                    $.LoadingOverlay('hide');
                    Swal.fire({
                        icon: 'success',
                        text: 'Akun mahasiswa berhasil diperbarui',
                        toast: true,
                        timerProgressBar: true,
                        timer: 1500,
                        showConfirmButton: false,
                        position: 'top-right',
                    }).then(() => {
                        location.reload();
                    })
                },
                error: (xhr, status) => {
                    $.LoadingOverlay('hide');
                    console.log(xhr);

                    if (xhr.status === 400) {
                        Swal.fire({
                            icon: 'warning',
                            text: xhr.responseJSON.message,
                            timer: 3000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-right',
                        });
                    } else if (xhr.status === 422) {
                        const { errors } = xhr.responseJSON;

                        $.each(errors, (key, value) => {
                            if (key === 'email' || key === 'password' || key === 'kd_user') {
                                $(`#formEditUser input[name="${key}"]`).after(
                                    `<div class="error-message text-danger small">${value}</div>`
                                );
                            }
                        });
                    } else {
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
                }
            })
        });
    });

    function deleteUser(element) {
        const { dataset } = element;

        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: 'Yakin untuk menghapus akun tersebut?',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/users/mahasiswa/delete',
                    type: 'DELETE',
                    data: {
                        _token: dataset.token,
                        user_id: dataset.user,
                    },
                    success: (response, status, xhr) => {
                        Swal.fire({
                            icon: 'success',
                            text: 'Akun mahasiswa berhasil dihapus',
                            toast: true,
                            showConfirmButton: false,
                            timerProgressBar: true,
                            timer: 1000,
                            position: 'top-right',
                        }).then(() => {
                            location.reload();
                        })
                    },
                    error: (xhr, status) => {
                        console.log(xhr);

                        Swal.fire({
                            icon: 'error',
                            text: 'Oops, something wrong. Contact your IT Support',
                            toast: true,
                            showConfirmButton: false,
                            timerProgressBar: true,
                            timer: 3000,
                            position: 'top-right',
                        });
                    }
                })
            }
        })
    }

    function editUser(element) {
        const { dataset } = element;

        $.ajax({
            url: '/users/mahasiswa/detail?user_id=' + dataset.user,
            type: 'GET',
            beforeSend: () => {
                $('#emailEdit').val('Loading...').prop('disabled', true);
                $('#nimEdit').val('Loading...').prop('disabled', true);
            },
            success: (response) => {
                const { data } = response;
                const kdUser = data.mahasiswa.kd_user.split('-');

                $('#userIdEdit').val(data.mahasiswa.id);
                $('#emailEdit').val(data.mahasiswa.email).prop('disabled', false);
                $('#nimEdit').val(kdUser[1]).prop('disabled', false);
            },
            error: (xhr) => {
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
        });

        $('#modalEditUser').modal('show');
    }
</script>
@endsection
