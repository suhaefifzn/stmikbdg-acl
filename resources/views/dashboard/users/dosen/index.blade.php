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
                Dosen
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
        <span>Tambah Akun Dosen</span>
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
                    <th style="text-align: left;">Kode</th>
                    <th>Email</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['list_dosen'] as $user)
                    @php
                        $kdUser = explode('-', $user['kd_user'])[1];
                    @endphp
                    <tr>
                        <td style="text-align: left;">{{ $loop->iteration }}</td>
                        <td>{{ $kdUser }}</td>
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

{{-- Modal add user --}}
<div class="modal fade" id="modalAddUser" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="modalAddUserLabel">
                    <i data-feather="plus" style="width: 1em;"></i>
                    Tambah Akun Dosen
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="formAddUser">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kd_user" class="form-label">Kode Dosen</label>
                        <input type="text" class="form-control" id="kd_user" name="kd_user" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="checkbox-wrapper d-flex px-3 mt-4">
                        <table class="table table- border-top">
                            <thead>
                                <tr>
                                    <th colspan="3" style="text-align: center;">Role Lainnya:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 150px">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_wk" name="is_wk">
                                            <label class="form-check-label" for="is_wk">
                                                Wakil Ketua
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width: 150px">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_prodi" name="is_prodi">
                                            <label class="form-check-label" for="is_prodi">
                                                Prodi
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width: 150px">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_doswal" name="is_doswal">
                                            <label class="form-check-label" for="is_doswal">
                                                Dosen Wali
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 150px">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_staff" name="is_staff">
                                            <label class="form-check-label" for="is_staff">
                                                Karyawan
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width: 150px" class="sub-karyawan d-none">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_akademik" name="is_akademik">
                                            <label class="form-check-label" for="is_akademik">
                                                Akademik
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width: 150px" class="sub-karyawan d-none">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_marketing" name="is_marketing">
                                            <label class="form-check-label" for="is_marketing">
                                                Marketing
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 150px" class="sub-karyawan d-none" colspan="3">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_baak" name="is_baak">
                                            <label class="form-check-label" for="is_baak">
                                                BAAK
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="buttonSubmitAddUser">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal edit user --}}
<div class="modal fade" id="modalEditUser" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="modalEditUserLabel">
                    <i data-feather="plus" style="width: 1em;"></i>
                    Edit Akun Dosen
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditUser">
                @csrf
                @method('put')
                <input type="hidden" id="userIdEdit">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kd_user_edit" class="form-label">Kode Dosen</label>
                        <input type="text" class="form-control" id="kd_user_edit" name="kd_user" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_edit" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_edit" name="email" autocomplete="off" required>
                    </div>
                    <div class="checkbox-wrapper d-flex px-3 mt-4">
                        <table class="table table- border-top">
                            <thead>
                                <tr>
                                    <th colspan="3" style="text-align: center;">Role Lainnya:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 150px">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_wk_edit" name="is_wk">
                                            <label class="form-check-label" for="is_wk_edit">
                                                Wakil Ketua
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width: 150px">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_prodi_edit" name="is_prodi">
                                            <label class="form-check-label" for="is_prodi_edit">
                                                Prodi
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width: 150px">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_doswal_edit" name="is_doswal">
                                            <label class="form-check-label" for="is_doswal_edit">
                                                Dosen Wali
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 150px">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_staff_edit" name="is_staff">
                                            <label class="form-check-label" for="is_staff_edit">
                                                Karyawan
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width: 150px" class="sub-karyawan d-none">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_akademik_edit" name="is_akademik">
                                            <label class="form-check-label" for="is_akademik_edit">
                                                Akademik
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width: 150px" class="sub-karyawan d-none">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_marketing_edit" name="is_marketing">
                                            <label class="form-check-label" for="is_marketing_edit">
                                                Marketing
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 150px" class="sub-karyawan d-none" colspan="3">
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_baak_edit" name="is_baak">
                                            <label class="form-check-label" for="is_baak_edit">
                                                BAAK
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="buttonSubmitEditUser">Submit</button>
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
                kd_user: $('#formAddUser #kd_user').val(),
                email: $('#formAddUser #email').val(),
                password: $('#formAddUser #password').val(),
                is_wk: $('#formAddUser #is_wk').is(':checked') ?? false,
                is_prodi: $('#formAddUser #is_prodi').is(':checked') ?? false,
                is_doswal: $('#formAddUser #is_baak').is(':checked') ?? false,
                is_staff: $('#formAddUser #is_staff').is(':checked') ?? false,
            };

            // cek checkbox, pilih role minimal 1
            if ($('#formAddUser input[type="checkbox"]:checked').length === 0) {
                return Swal.fire({
                    icon: 'warning',
                    text: 'Mohon tentukan role untuk akun yang akan ditambahkan',
                    toast: true,
                    timerProgressBar: true,
                    timer: 1500,
                    showConfirmButton: false,
                    position: 'top-right'
                });
            }

            // jika role staff atau karyawan true
            if ($('#formAddUser #is_staff').is(':checked')) {
                if ($('#formAddUser .sub-karyawan input[type="checkbox"]:checked').length === 0) {
                    // tidak ada yang dipilih
                    return Swal.fire({
                        icon: 'warning',
                        text: 'Mohon tentukan role karyawan untuk akun yang akan ditambahkan',
                        toast: true,
                        timerProgressBar: true,
                        timer: 1500,
                        showConfirmButton: false,
                        position: 'top-right'
                    });
                } else {
                    data.is_akademik = $('#formAddUser #is_akademik').is(':checked') ?? false;
                    data.is_marketing = $('#formAddUser #is_marketing').is(':checked') ?? false;
                    data.is_baak = $('#formAddUser #is_baak').is(':checked') ?? false;
                }
            }

            $.ajax({
                url: '/users/dosen/add',
                type: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                beforeSend: () => {
                    $.LoadingOverlay('show');
                },
                success: (response, status, xhr) => {
                    $.LoadingOverlay('hide');
                    Swal.fire({
                        icon: 'success',
                        text: 'Akun dosen berhasil ditambahkan',
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
                            if (key === 'email' || key === 'password' || key === 'kd_user' ) {
                                $(`#formAddUser input[name="${key}"]`).after(
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

        // is_staff di add user
        $('#formAddUser #is_staff').on('change', (e) => {
            e.preventDefault();

            if (e.delegateTarget.checked) {
                $('#formAddUser .sub-karyawan').removeClass('d-none');
            } else {
                $('#formAddUser .sub-karyawan').addClass('d-none');
            }
        });

        // is_staff di edit user
        $('#formEditUser #is_staff_edit').on('change', (e) => {
            e.preventDefault();

            if (e.delegateTarget.checked) {
                $('#formEditUser .sub-karyawan').removeClass('d-none');
            } else {
                $('#formEditUser .sub-karyawan input[type="checkbox"]').prop('checked', false);
                $('#formEditUser .sub-karyawan').addClass('d-none');
            }
        });

        // edit user
        $('#formEditUser').on('submit', (e) => {
            e.preventDefault();
            $('#formEditUser .error-message').remove();

            const data = {
                _token: $('#formEditUser input[name="_token"]').val(),
                _method: $('#formEditUser input[name="_method"]').val(),
                user_id: $('#formEditUser #userIdEdit').val(),
                kd_user: $('#formEditUser #kd_user_edit').val(),
                email: $('#formEditUser #email_edit').val(),
                is_wk: $('#formEditUser #is_wk_edit').is(':checked') ?? false,
                is_prodi: $('#formEditUser #is_prodi_edit').is(':checked') ?? false,
                is_doswal: $('#formEditUser #is_doswal_edit').is(':checked') ?? false,
                is_staff: $('#formEditUser #is_staff_edit').is(':checked') ?? false,
            };

            // cek checkbox, pilih role minimal 1
            if ($('#formEditUser input[type="checkbox"]:checked').length === 0) {
                e.preventDefault();
                return Swal.fire({
                    icon: 'warning',
                    text: 'Mohon tentukan role untuk akun yang akan Anda ubah',
                    toast: true,
                    timerProgressBar: true,
                    timer: 1500,
                    showConfirmButton: false,
                    position: 'top-right'
                });
            }

            // jika role staff atau karyawan true
            if ($('#formEditUser #is_staff_edit').is(':checked')) {
                if ($('#formEditUser .sub-karyawan input[type="checkbox"]:checked').length === 0) {
                    // tidak ada yang dipilih
                    return Swal.fire({
                        icon: 'warning',
                        text: 'Mohon tentukan role karyawan untuk akun yang akan diubah',
                        toast: true,
                        timerProgressBar: true,
                        timer: 1500,
                        showConfirmButton: false,
                        position: 'top-right'
                    });
                } else {
                    data.is_akademik = $('#formEditUser #is_akademik_edit').is(':checked') ?? false;
                    data.is_marketing = $('#formEditUser #is_marketing_edit').is(':checked') ?? false;
                    data.is_baak = $('#formEditUser #is_baak_edit').is(':checked') ?? false;
                }
            } else {
                data.is_staff = false;
                data.is_akademik = false;
                data.is_marketing = false;
                data.is_baak = false;
            }

            $.ajax({
                url: '/users/dosen/update',
                type: 'PUT',
                data: JSON.stringify(data),
                contentType: 'application/json',
                beforeSend: () => {
                    $.LoadingOverlay('show');
                },
                success: (response, status, xhr) => {
                    $.LoadingOverlay('hide');
                    Swal.fire({
                        icon: 'success',
                        text: 'Akun dosen berhasil diperbarui',
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
                            if (key === 'email' || key === 'kd_user' ) {
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
                    url: '/users/dosen/delete',
                    type: 'DELETE',
                    data: {
                        _token: dataset.token,
                        user_id: dataset.user,
                    },
                    success: (response, status, xhr) => {
                        Swal.fire({
                            icon: 'success',
                            text: 'Akun dosen berhasil dihapus',
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
        // reset checkbox
        $('#formEditUser .sub-karyawan').addClass('d-none')
        $('#formEditUser input[type="checkbox"]').prop('checked', false);

        const { dataset } = element;

        $.ajax({
            url: '/users/dosen/detail?user_id=' + dataset.user,
            type: 'GET',
            beforeSend: () => {
                $('#kd_user_edit').val('Loading...').prop('disabled', true);
                $('#email_edit').val('Loading...').prop('disabled', true);
            },
            success: (response) => {
                const { data } = response;

                const filteredRoles = (data) => {
                    let booleanObject = {};
                    $.each(data.dosen, function(key, value) {
                        if (typeof value === 'boolean') {
                            booleanObject[key] = value;
                        }
                    });
                    return booleanObject;
                };

                const splittedKdUser = data.dosen.kd_user.split('-');

                $('#userIdEdit').val(data.dosen.id);
                $('#kd_user_edit').val(splittedKdUser[1]).prop('disabled', false);
                $('#email_edit').val(data.dosen.email).prop('disabled', false);

                $.each(filteredRoles(data), (key, value) => {
                    if (value) {
                        $(`#formEditUser input[name="${key}"]`).prop('checked', true);
                    }
                });

                if ($('#formEditUser #is_staff_edit').is(':checked')) {
                    $('#formEditUser .sub-karyawan').removeClass('d-none').fadeIn();
                }
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
