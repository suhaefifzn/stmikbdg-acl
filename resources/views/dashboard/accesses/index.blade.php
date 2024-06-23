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
                Accesses
            </li>
        </ol>
    </nav>
</div>
@endsection
@section('content')

{{-- Form pilih web --}}
<div class="d-flex justify-content-between align-items-center">
    <div class="col-lg-6">
        <form id="formSelectWeb" class="input-group">
            <select class="form-select form-control" name="web" id="selectWeb">
                <option value="" selected disabled hidden>
                    Lihat daftar akses user ke sistem informasi
                </option>
                @foreach ($data['list_site'] as $site)
                    <option value="{{ $site['id'] }}">{{ $site['name'] }}</option>
                @endforeach
            </select>
            <button class="btn btn-success" type="submit" title="Cari">
                <i data-feather="search" width="1.3em"></i>
            </button>
        </form>
    </div>

    {{-- Button add akses user --}}
    <div class="d-flex gap-2 align-items-center">
        <button class="btn btn-primary d-flex gap-1 align-items-center" id="buttonModalAddUserAccess">
            <i data-feather="check-square" width="1em"></i>
            <span>Tambah Akses</span>
        </button>
        <button class="btn btn-secondary d-flex gap-1 align-items-center" id="buttonModalAddNewSite">
            <i data-feather="link" width="1em"></i>
            <span>Tambah URL</span>
        </button>
    </div>
</div>

{{-- Table --}}
<div class="table-wrapper mt-3" id="tableWrapper">
</div>

{{-- modal add site --}}
<div class="modal fade" id="modalAddSite" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="modalAddSiteLabel">
                <i data-feather="link" style="width: 1em;"></i>
                Tambah URL
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form method="post" id="formAddSite">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="namaSistemAdd" class="form-label">Nama Sistem Informasi</label>
                        <input type="text" class="form-control" id="namaSistemAdd" required>
                    </div>
                    <div class="mb-3">
                        <label for="urlAdd" class="form-label">Alamat Web</label>
                        <input type="text" class="form-control" id="urlAdd" required>
                    </div>
                    <div class="checkbox-wrapper d-flex px-3 mt-4">
                        <table class="table table- border-top">
                            <thead>
                                <tr>
                                    <th colspan="3" style="text-align: center;">Tersedia untuk Role:</th>
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
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_dev" name="is_dev">
                                            <label class="form-check-label" for="is_dev">
                                                Developer
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_wk" name="is_wk">
                                            <label class="form-check-label" for="is_wk">
                                                Wakil Ketua
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_staff" name="is_staff">
                                            <label class="form-check-label" for="is_staff">
                                                Karyawan
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-flex align-items-center gap-1">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_secretary" name="is_secretary">
                                            <label class="form-check-label" for="is_secretary">
                                                Secretary
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="buttonSubmitAddSite">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal add user akses --}}
<div class="modal fade" id="modalAddUserAccess" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="modalAddUserAccessLabel">
                <i data-feather="check-square" style="width: 1em;"></i>
                Tambah Akses
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form method="post" id="formAddUserAccess">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <select class="form-select" id="selectAlamatWeb">
                            <option value="" selected disabled hidden>Pilih sistem informasi</option>
                            @foreach ($data['list_site'] as $site)
                                <option value="{{ $site['id'] }}">{{ $site['name'] }}</option>
                            @endforeach
                          </select>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" id="selectUser">
                            <option value="" selected disabled hidden>Pilih user</option>
                            @foreach ($data['list_user'] as $user)
                                <option value="{{ $user['id'] }}">{{ $user['email'] }}</option>
                            @endforeach
                          </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="buttonSubmitAddUserAccess">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(() => {
        // inisiasi select2 di modal
        $('#selectAlamatWeb, #selectUser').select2({
            dropdownParent: $("#modalAddUserAccess"),
            width: '100%',
        });

        $('#selectWeb').select2();

        // modal add site
        $('#buttonModalAddNewSite').on('click', (e) => {
            e.preventDefault();
            $('#formAddSite #url').val('');
            $('#modalAddSite').modal('show');
        });

        // user access list
        $("#formSelectWeb").submit((e) => {
            e.preventDefault();

            const siteId = $('#selectWeb').find(':selected').val();

            if (siteId === '') {
                return Swal.fire({
                    icon: 'warning',
                    text: 'Mohon pilih sistem informasi',
                    timer: 3000,
                    timerProgressBar: true,
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-right'
                });
            }

            $.ajax({
                url: `/accesses/render-table?site_id=${siteId}`,
                type: 'GET',
                beforeSend: () => {
                    $.LoadingOverlay('show');
                },
                success: (response) => {
                    $('#tableWrapper').html(response.content);

                    $('#myTable').dataTable({
                        'pageLength': 5,
                        'lengthMenu': [[5, 10, 15, -1], [5, 10, 15, 'All']],
                        'ordering': false,
                    });
                    feather.replace();
                },
                error: (xhr, status) => {
                    console.log(xhr);
                },
                complete: () => {
                    $.LoadingOverlay('hide');
                }
            });
        });

        // submit add site
        $('#formAddSite').on('submit', (e) => {
            e.preventDefault();

            const data = {
                _token: $('#formAddSite input[name="_token"]').val(),
                url: $('#formAddSite #urlAdd').val(),
                name: $('#formAddSite #namaSistemAdd').val(),
                is_mhs: $('#formAddSite #is_mhs').is(':checked') ? true : false,
                is_dosen: $('#formAddSite #is_dosen').is(':checked') ? true : false,
                is_doswal: $('#formAddSite #is_doswal').is(':checked') ? true : false,
                is_prodi: $('#formAddSite #is_prodi').is(':checked') ? true : false,
                is_admin: $('#formAddSite #is_admin').is(':checked') ? true : false,
                is_dev: $('#formAddSite #is_developer').is(':checked') ? true : false,
                is_wk: $('#formAddSite #is_wk').is(':checked') ? true : false,
                is_staff: $('#formAddSite #is_staff').is(':checked') ? true : false,
                is_secretary: $('#formAddSite #is_secretary').is(':checked') ? true : false,
            };

            // console.log(data); return;

            $.ajax({
                url: '/accesses/site/add',
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

        // open modal add user access
        $('#buttonModalAddUserAccess').on('click', (e) => {
            e.preventDefault();
            $('#modalAddUserAccess').modal('show');
        });

        // add akses user
        $('#formAddUserAccess').on('submit', (e) => {
            e.preventDefault();

            const data = {
                _token: $('#formAddUserAccess input[name="_token"]').val(),
                site_id: $('#selectAlamatWeb').find(':selected').val(),
                user_id: $('#selectUser').find(':selected').val(),
            };

            $.ajax({
                url: '/accesses/user/add',
                type: 'POST',
                data,
                beforeSend: () => {
                    $.LoadingOverlay('show');
                },
                success: (response, status, xhr) => {
                    $.LoadingOverlay('hide');
                    Swal.fire({
                        icon: 'success',
                        text: 'Akses pengguna berhasil ditambahkan',
                        toast: true,
                        timerProgressBar: true,
                        timer: 1500,
                        showConfirmButton: false,
                        position: 'top-right',
                    }).then(() => {
                        $('#modalAddUserAccess').modal('hide');
                        $('#selectWeb')
                            .find(`option[value="${data.site_id}"]`)
                            .prop('selected', true);
                        $('#formSelectWeb').trigger('submit');
                    })
                },
                error: (xhr, status) => {
                    $.LoadingOverlay('hide');
                    console.log(xhr);

                    if (xhr.status === 400) {
                        return Swal.fire({
                            icon: 'warning',
                            text: xhr.responseJSON.message,
                            timer: 3000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-right',
                        });
                    }

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
            })
        });
    });

    function deleteAccess(element) {
        const { dataset } = element;

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
                    url: '/accesses/delete',
                    type: 'DELETE',
                    data: {
                        user_id: dataset.user,
                        site_id: dataset.site,
                        _token: dataset.token,
                    },
                    success: (response, status, xhr) => {
                        Swal.fire({
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
