<!doctype html>
<html lang="en">
  <head>
    <title>STMIK Bandung {{ isset($title) ? '- ' . $title : '' }}</title>

    {{-- Meta Tags --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="STMIK Bandung">
    <meta name="keyword" content="stmikbandung-acl">
    <meta name="theme-color" content="#000">
    <meta name="description"
        content="Sistem untuk mengelola akses pengguna ke layanan sistem informasi STMIK Bandung"
    >

    {{-- Favicons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/favicon-16x16.png">
    <meta name="theme-color" content="#ffffff">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    {{-- Data Table --}}
    <link rel="stylesheet" href="/assets/datatables/css/datatables.min.css">
    <link rel="stylesheet" href="/assets/datatables/css/datatables.bootstrap5.min.css">
    <link rel="stylesheet" href="/assets/datatables/css/roworder.bootstrap5.min.css">
    {{-- Select2 --}}
    <link rel="stylesheet" href="/assets/select2/css/select2.min.css" />

    {{-- Main Style --}}
    <link rel="stylesheet" href="/assets/main/css/style.css">
    <link rel="stylesheet" href="/assets/main/css/sidebar.css">
    <link rel="stylesheet" href="/assets/main/css/breadcrumbs.css">

    {{-- Feather Icons --}}
    <script src="/assets/feather-icons/js/feather.min.js"></script>
    {{-- JQuery --}}
    <script src="/assets/jquery/js/jquery.min.js"></script>
    {{-- Loding Overlay --}}
    <script src="/assets/loading-overlay/js/loading.min.js"></script>
    {{-- Data Tables --}}
    <script src="/assets/datatables/js/datatables.min.js"></script>
    <script src="/assets/datatables/js/datatables.bootstrap5.min.js"></script>
    <script src="/assets/datatables/js/datatables.roworder.min.js"></script>
    <script src="/assets/datatables/js/roworder.bootstrap5.min.js"></script>
    {{-- Sweet Alert --}}
    <script src="/assets/sweetalert/js/sweet.min.js"></script>
    {{-- Select 2 --}}
    <script src="/assets/select2/js/select2.min.js"></script>
  </head>
  <body>
    <main class="d-flex flex-nowrap">

        {{-- Sidebar Menu --}}
        @include('dashboard.sidebar')

        <div class="b-example-divider b-example-vr"></div>
            <div class="dashboard-content-wrapper p-3 overflow-y-scroll" style="width: 100%">
                <div class="container">
                    {{-- Breadcrumbs--}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                        <symbol id="house-door-fill" viewBox="0 0 16 16">
                            <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5z"/>
                        </symbol>
                    </svg>

                    @yield('breadcrumbs')

                    <div class="mt-4">
                        {{-- Content --}}
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Bootstrap --}}
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>

    {{-- JavaScript --}}
    @yield('scripts')

    {{-- Feather Icons --}}
    <script>
      feather.replace();
    </script>

    {{-- Clock --}}
    <script>
        $(document).ready(function() {
            function updateClock() {
                var now = new Date();

                var hours = now.getHours().toString().padStart(2, '0');
                var minutes = now.getMinutes().toString().padStart(2, '0');
                var seconds = now.getSeconds().toString().padStart(2, '0');
                var timeString = hours + ':' + minutes + ':' + seconds;

                var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\`at', 'Sabtu'];
                var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                var day = days[now.getDay()];
                var date = now.getDate().toString().padStart(2, '0');
                var month = months[now.getMonth()];
                var year = now.getFullYear();
                var dateString = day + ', ' + date + ' ' + month + ' ' + year;

                $('.clock-sidebar').text(timeString);
                $('.date-sidebar').text(dateString);
            }

            updateClock();
            setInterval(updateClock, 1000);
        });
    </script>
  </body>
</html>
