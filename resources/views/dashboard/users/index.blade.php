@extends('dashboard.main')
@section('dashboard_content')
<div class="container">
    <div class="row col-lg-8">
        {{-- Button add akses user --}}
        <div>
            <button class="btn btn-primary d-flex gap-1 align-items-center" id="buttonModalAddUser">
                <i data-feather="user" width="1.3em"></i>
                <span>Tambah User</span>
            </button>
        </div>

        {{-- Form upload excel --}}
        <form action="post" class="mt-3" id="formUploadExcel" enctype="multipart/form-data">
            @csrf
            <div class="label mb-2"><b>Import Excel File:</b></div>
            <div class="input-group">
                <input type="file" class="form-control" id="inputFileExcel" title="Upload File Excel" accept=".xls,.xlsx,.csv">
                <button class="btn btn-success" id="buttonInputFileExcel" title="Upload">
                    <i data-feather="upload" width="1.3em"></i>
                </button>
            </div>
            <div class="ps-2 small" id="textShowFormatExcel">
                <span style="cursor: pointer; color:rgb(53, 88, 247)">*Lihat format excel</span>
            </div>
        </form>

        {{-- Table --}}
        <div class="table-wrapper mt-5">
            <table id="myTable" class="mx-0" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="text-align: left;">No</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td style="text-align: left;">{{ $loop->iteration }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="badge bg-info border-0" title="View" data-user="{{ $user['kd_user'] }}" onclick="viewUser(this)">
                                        <i data-feather="eye" style="width: 1.3em"></i>
                                    </button>
                                    <button class="badge bg-danger border-0" title="Delete" data-user="{{ $user['kd_user'] }}" onclick="deleteUser(this)">
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
</div>

{{-- modal show format excel --}}
<div class="modal fade" id="modalShowFormatExcelAddUserAccess" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="modalShowFormatExcelAddUserAccessLabel">
                <i data-feather="image" style="width: 1em;"></i>
                Format Excel
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">
                <img src="https://lh3.googleusercontent.com/drive-viewer/AKGpihbsqnQK2rGk5TdJJqqPjW8OQ2q-CrGOdzCfxOGop6myvaV58zKC0thp3vVtCMzxYBDw1GQOjlQtgiAfRxe0xudIoWB4=s1600" alt="Format excel add user site access" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>

{{-- modal add user --}}
<div class="modal fade" id="modalAddUser" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="modalAddUserLabel">
                <i data-feather="user" style="width: 1em;"></i>
                Add New User
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form method="post" action="/users/add" id="formAddUser" class="overflow-y-scroll">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="kd_user" class="form-label">NIM/Kode Dosen</label>
                        <input type="text" class="form-control" id="kd_user" name="kd_user">
                    </div>
                    <div class="checkbox-wrapper d-flex px-3">
                        <table class="table table- border-top">
                            <thead>
                                <tr>
                                    <th colspan="3" style="text-align: center;">Pilih Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_mhs" name="is_mhs">
                                            <label class="form-check-label" for="is_mhs">
                                                Mahasiswa
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_dosen" name="is_dosen">
                                            <label class="form-check-label" for="is_dosen">
                                                Dosen
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_doswal" name="is_doswal">
                                            <label class="form-check-label" for="is_doswal">
                                                Dosen Wali
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_prodi" name="is_prodi">
                                            <label class="form-check-label" for="is_prodi">
                                                Prodi
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_admin" name="is_admin">
                                            <label class="form-check-label" for="is_admin">
                                                Admin
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_developer" name="is_developer">
                                            <label class="form-check-label" for="is_developer">
                                                Developer
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

<script>
    $(document).ready(() => {
        $('#myTable').dataTable({
            'pageLength': 5,
            'lengthMenu': [[5, 10, 15, -1], [5, 10, 15, 'All']],
            'ordering': false,
        });

        // Open modal add user access
        $('#buttonModalAddUser').on('click', (e) => {
            e.preventDefault();
            $('#formChangePassword .error-message').remove();
            $('#modalAddUser').modal('show');
        });

        // Add new user
        $('#formAddUser').on('submit', (e) => {
            e.preventDefault();
            $('#formChangePassword .error-message').remove();

            const data = {
                _token: $('#formAddUser input[name="_token"]').val(),
                kd_user: $('#formAddUser #kd_user').val(),
                email: $('#formAddUser #email').val(),
                password: $('#formAddUser #password').val(),
                is_mhs: $('#formAddUser #is_mhs').prop('checked') ?? false,
                is_dosen: $('#formAddUser #is_dosen').prop('checked') ?? false,
                is_doswal: $('#formAddUser #is_doswal').prop('checked') ?? false,
                is_prodi: $('#formAddUser #is_prodi').prop('checked') ?? false,
                is_admin: $('#formAddUser #is_admin').prop('checked') ?? false,
                is_developer: $('#formAddUser #is_developer').prop('checked') ?? false,
            };

            $.ajax({
                url: '/users/add',
                type: 'POST',
                data,
                beforeSend: () => {
                    $.LoadingOverlay('show');
                },
                success: (response, status, xhr) => {
                    $.LoadingOverlay('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'User berhasil ditambahkan',
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
                            title: 'Peringatan!',
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
                                $(`input[name="${key}"]`).after(
                                    `<div class="error-message text-danger small">${value}</div>`
                                );
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
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

        // import file excel
        $('#formUploadExcel').on('submit', (e) => {
            e.preventDefault();

            const formData = {
                _token: $('#formUploadExcel input[name="_token"]').val(),
                file: $('#inputFileExcel').last()[0].files[0],
            };
            const excel = new FormData();

            $.each(formData, (key, value) => {
                excel.append(key, value);
            });

            $.ajax({
                url: '/users/import-excel',
                type: 'POST',
                data: excel,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: () => {
                    $.LoadingOverlay('show');
                },
                success: (response, status, xhr) => {
                    $.LoadingOverlay('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Daftar users dari file excel berhasil ditambahkan',
                        toast: true,
                        timer: 1500,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        position: 'top-right',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: (xhr, status) => {
                    console.log(xhr);
                    $.LoadingOverlay('hide');

                    if (xhr.status === 422) {
                        return Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan!',
                            text: xhr.responseJSON.message,
                            toast: true,
                            timer: 3000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            position: 'top-right',
                        });
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Oops, something wrong. Contact your IT Support',
                        toast: true,
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        position: 'top-right',
                    });
                }
            })
        });

        // show modal image format excel
        $('#textShowFormatExcel').on('click', (e) => {
            e.preventDefault();
            $('#modalShowFormatExcelAddUserAccess').modal('show');
        })

        // submit add site
        $('#formAddSite').on('submit', (e) => {
            e.preventDefault();

            $.ajax({
                url: '/user-access/site/add',
                type: 'POST',
                data: {
                    _token: $('#formAddSite input[name="_token"]').val(),
                    url: $('#formAddSite #url').val(),
                },
                beforeSend: () => {
                    $.LoadingOverlay('show');
                },
                success: (response, status, xhr) => {
                    $.LoadingOverlay('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: response.message,
                        toast: true,
                        timer: 1500,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        position: 'top-right',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: (xhr, status) => {
                    $.LoadingOverlay('hide');
                    console.log(xhr);

                    if (xhr.status === 422) {
                        return  Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan!',
                            text: xhr.responseJSON.message,
                            toast: true,
                            timer: 3000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            position: 'top-right',
                        });
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Oops, something wrong. Contact your IT Support',
                        toast: true,
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        position: 'top-right',
                    });
                }
            });
        });
    });

    function viewUser(element) {
        const { dataset } = element;

        Swal.fire({
            icon: 'info',
            text: 'API belum tersedia',
            toast: true,
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
            position: 'top-right',
        });
    }

    function deleteUser(element) {
        const { dataset } = element;

        return Swal.fire({
            icon: 'info',
            text: 'API belum tersedia',
            toast: true,
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
            position: 'top-right',
        });

        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: 'Yakin untuk menghapus akses milik pengguna tersebut?',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/user-access/delete',
                    type: 'DELETE',
                    data: {
                        user_id: dataset.user,
                        site_id: dataset.site,
                        _token: dataset.token,
                    },
                    success: (response, status, xhr) => {
                        Swal.fire({
                            title: 'Sukses!',
                            icon: 'success',
                            text: 'Akses pengguna berhasil dihapus',
                            toast: true,
                            showConfirmButton: false,
                            timerProgressBar: true,
                            timer: 1500,
                            position: 'top-right',
                        }).then(() => {
                            $('#formSelectWeb #selectWeb')
                                .find(`option[value="${dataset.site}"]`)
                                .prop('selected', true);
                            $('#formSelectWeb').trigger('submit');
                        })
                    },
                    error: (xhr, status) => {
                        console.log(xhr);

                        Swal.fire({
                            title: 'Error!',
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
</script>
@endsection
