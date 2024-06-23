<div class="col-lg-6 mb-3">
    <table id="siteInfo" class="table">
        <thead>
            <tr>
                <th width="150">Alamat web</th>
                <th>:</th>
                <td>{{ $data['site_detail']['url'] }}</td>
            </tr>
            <tr>
                <th>Total akses</th>
                <th>:</th>
                <td>{{ count($data['user_accesses']) }}</td>
            </tr>
            <tr>
                <th>Tersedia untuk</th>
                <th>:</th>
                <td>{{ $data['site_role'] }}</td>
            </tr>
        </thead>
    </table>
</div>

<table id="myTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th style="text-align: left;">No</th>
            <th>Email</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data['user_accesses'] as $user)
            <tr>
                <td style="text-align: left;">{{ $loop->iteration }}</td>
                <td>{{ $user['user_email'] }}</td>
                <td>
                    <div class="d-flex gap-1 justify-content-center">
                        <button class="badge bg-danger border-0" title="Delete" data-user="{{ $user['user_id'] }}" data-site="{{ $user['site_id'] }}" data-token="{{ csrf_token() }}" onclick="deleteAccess(this)">
                            <i data-feather="x-circle" style="width: 1.3em"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
