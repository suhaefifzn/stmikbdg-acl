@extends('dashboard.main')
@section('dashboard_content')
<div class="container">
    <div class="row col-lg-8">
        {{-- Button add akses user --}}
        <div class="d-flex gap-2">
            <button class="btn btn-primary" id="buttonModalAddUserAccess">
                <i data-feather="check-square" width="1.3em"></i>
                <span>Tambah Akses</span>
            </button>
            <button class="btn btn-secondary" id="buttonModalAddNewSite">
                <i data-feather="link" width="1.3em"></i>
                <span>Tambah URL</span>
            </button>
        </div>

        {{-- Form pilih web --}}
        <form id="formSelectWeb" class="input-group mt-3">
            <select class="form-select form-control" name="web" id="selectWeb">
                <option value="" selected disabled hidden>
                    Lihat daftar akses user pada alamat web
                </option>
                @foreach ($sites as $site)
                    <option value="{{ $site['id'] }}">{{ $site['url'] }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" type="submit" title="Cari">
                <i data-feather="search" width="1.3em"></i>
            </button>
        </form>

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
        <div class="table-wrapper mt-5 d-none">
            <table id="myTable" class="mx-0" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="text-align: left;">No</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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
                Add User Access
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form method="post" class="overflow-y-scroll" id="formAddUserAccess">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <select class="form-select" id="selectAlamatWeb">
                            <option value="" selected disabled hidden>Pilih alamat web</option>
                            @foreach ($sites as $site)
                                <option value="{{ $site['id'] }}">{{ $site['url'] }}</option>
                            @endforeach
                          </select>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" id="selectUser">
                            <option value="" selected disabled hidden>Pilih user</option>
                            @foreach ($users as $user)
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

{{-- modal show format excel --}}
<div class="modal fade" id="modalShowFormatExcelAddUserAccess" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="modalShowFormatExcelAddUserAccessLabel">
                <i data-feather="image" style="width: 1em;"></i>
                Format Excel
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">
                <img src="https://lh3.googleusercontent.com/drive-viewer/AKGpihbppqK1KRx9h4RWNaxrtTCt024nRGwlAFgMal5Fmu0A1sKRvYgtGzPogF2dfGEobE-8fj-ocJm5H32VaHY75qN8hgLs=s2560" alt="Format excel add user site access" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>

{{-- modal add site --}}
<div class="modal fade" id="modalAddSite" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="modalAddSiteLabel">
                <i data-feather="link" style="width: 1em;"></i>
                Add New Site
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form method="post" class="overflow-y-scroll" id="formAddSite">
                @csrf
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="url">URL</label>
                        <input type="text" class="form-control" id="url" name="url">
                      </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="buttonSubmitAddSite">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        // inisiasi select2 di modal
        $('#selectAlamatWeb, #selectUser').select2({
            dropdownParent: $("#modalAddUserAccess"),
            width: '100%',
        });

        $("#formSelectWeb").submit((e) => {
            e.preventDefault();

            if ($.fn.DataTable.isDataTable('#myTable')) {
                $('#myTable colgroup').remove();
                $('#myTable').DataTable().destroy();
            }

            const siteId = $('#selectWeb').find(':selected').val();

            if (siteId === '') {
                return Swal.fire({
                    icon: 'warning',
                    text: 'Mohon pilih alamat web',
                    timer: 3000,
                    timerProgressBar: true,
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-right'
                });
            }

            $.ajax({
                url: `/user-access/users?site_id=${siteId}`,
                type: 'GET',
                beforeSend: () => {
                    $.LoadingOverlay('show');
                },
                success: (response, status, xhr) => {
                    const { data: { site_users } } = response;
                    let tempElement = '';

                    site_users.forEach((item, index) => {
                        tempElement += `
                            <tr>
                                <td style="text-align: left;">${++index}</td>
                                <td>${item.user_email}</td>
                                <td>
                                    <button class="badge bg-danger border-0" title="Delete Access" onclick="deleteAccess(this)" data-token="{{ csrf_token() }}" data-user="${item.user_id}" data-site="${item.site_id}"">
                                        <i data-feather="x-circle" width="1.5em"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });

                    $('#myTable tbody').html(tempElement);
                    feather.replace();
                    $('.table-wrapper').removeClass('d-none');
                    $('#myTable').dataTable({
                        'pageLength': 5,
                        'lengthMenu': [[5, 10, 15, -1], [5, 10, 15, 'All']],
                        'ordering': false,
                    });
                    $.LoadingOverlay('hide');
                },
                error: (xhr, status) => {
                    console.log(xhr);
                    $.LoadingOverlay('hide');
                }
            });
        });

        // Open modal add user access
        $('#buttonModalAddUserAccess').on('click', (e) => {
            e.preventDefault();
            $('#modalAddUserAccess').modal('show');
        });

        // Add akses user
        $('#formAddUserAccess').on('submit', (e) => {
            e.preventDefault();

            const data = {
                _token: $('#formAddUserAccess input[name="_token"]').val(),
                site_id: $('#selectAlamatWeb').find(':selected').val(),
                user_id: $('#selectUser').find(':selected').val(),
            };

            $.ajax({
                url: '/user-access/add',
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
                        text: 'Akes pengguna berhasil ditambahkan',
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
                            title: 'Peringatan!',
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
                        title: 'Error!',
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
                url: '/user-access/import-excel',
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
                        text: 'Daftar akses pengguna dari file excel berhasil ditambahkan',
                        toast: true,
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        position: 'top-right',
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

        // modal add site
        $('#buttonModalAddNewSite').on('click', (e) => {
            e.preventDefault();
            $('#formAddSite #url').val('');
            $('#modalAddSite').modal('show');
        });

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
