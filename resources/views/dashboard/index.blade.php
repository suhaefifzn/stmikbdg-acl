<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="STMIK Bandung">
    <title>STMIK Bandung - ACL</title>

    {{-- Favicons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/favicon-16x16.png">
    <meta name="theme-color" content="#ffffff">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    {{-- Feather Icons --}}
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    {{-- JQuery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- Data Table --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="http://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
    <body>
        <main>
            <div class="container">
                <div class="row flex-column">
                    <div class="border-bottom py-2 mt-2 d-flex">
                        <h3 class="fw-bold">STMIK Bandung - Access Control Level</h3>
                        <button class="btn btn-secondary ms-auto" type="button" id="buttonLogout" title="Logout">
                            <i data-feather="log-out"></i>
                        </button>
                    </div>
                    <div class="col-lg-6 my-3">
                        <form id="formSelectWeb" class="input-group">
                            <select class="form-select form-control" name="web" id="selectWeb">
                                <option value="" selected disabled hidden>Select web</option>
                                @foreach ($sites as $site)
                                    <option value="{{ $site['id'] }}">{{ $site['url'] }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary" type="submit" title="Cari">
                                <i data-feather="search"></i>
                            </button>
                        </form>
                        <form id="formSelectUser" class="input-group mt-3">
                            @csrf
                            <select class="form-select form-control" name="user" id="selectUser">
                                <option value="" selected disabled hidden>Select user</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user['id'] }}">{{ $user['email'] }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary" type="submit" title="Tambahkan ke web di atas">
                                <i data-feather="plus"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div class="table-wrapper d-none">
                            <table id="myTable" class="mx-0" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        {{-- Bootstrap --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        {{-- Feather Icons --}}
        <script>
            feather.replace()
        </script>

        <script>
            $('#myTable').dataTable({
                'pageLength': 5,
                'lengthMenu': [[5, 10, 15, -1], [5, 10, 15, 'All']],
                'ordering': false,
            });

            $("#formSelectWeb").submit((e) => {
                e.preventDefault();

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
                    url: `/site-user?site_id=${siteId}`,
                    type: 'GET',
                    success: (response, status, xhr) => {
                        const { data: { site_users } } = response;
                        let tempElement = '';

                        site_users.forEach((item, index) => {
                            tempElement += `
                                <tr>
                                    <td>${++index}</td>
                                    <td>${item.user_email}</td>
                                </tr>
                            `;
                        });

                        $('#myTable tbody').html(tempElement);
                        $('.table-wrapper').removeClass('d-none');
                    },
                    error: (xhr, status) => {
                        console.log(xhr);
                    }
                });
            });

            $('#formSelectUser').submit((e) => {
                e.preventDefault();

                const siteId = $('#selectWeb').find(':selected').val();
                const userId = $('#selectUser').find(':selected').val();

                if (!siteId && !userId) {
                    return Swal.fire({
                        icon: 'warning',
                        text: 'Mohon pilih alamat web dan user terlebih dahulu',
                        timer: 3000,
                        timerProgressBar: true,
                        toast: true,
                        showConfirmButton: false,
                        position: 'top-right'
                    });
                }

                $.ajax({
                    url: '/site-user',
                    type: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        site_id: siteId,
                        user_id: userId,
                    },
                    success: (response, status, xhr) => {
                        Swal.fire({
                            icon: 'success',
                            text: 'Berhasil menambahkan akses web ke user',
                            timer: 3000,
                            timerProgressBar: true,
                            toast: true,
                            showConfirmButton: false,
                            position: 'top-right'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: (xhr, status) => {
                        console.log(xhr);
                    }
                })
            });

            $('#buttonLogout').on('click', () => {
                window.location = '/logout';
            });
        </script>
    </body>
</html>
