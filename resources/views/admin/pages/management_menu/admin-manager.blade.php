@extends('admin.layout.master')

@section('content_admin')
    <div class="row">
        <h1>Quản lý Admin</h1>
        <hr>
        <form action="{{ route('admin.user-manager') }}" method="get">
            <div class="d-flex mb-3">
                <label for="name" class="mt-3 me-3 fs-3">Tên Admin: </label>
                <input type="text" name="name" class="form-control w-25 me-3" style="height: 40px">
                <button type="submit" class="btn btn-primary m-0 px-2">Tìm kiếm</button>
            </div>
        </form>
        <div class="mt-3">
            <table class="table table-bordered table-post-list">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">STT</th>
                        <th class="text-center" style="width: 12%;">Tên Admin</th>
                        <th class="text-center" style="width: 12%;">Email</th>
                        <th class="text-center" style="width: 10%;">Ngày tạo</th>
                        <th class="text-center" style="width: 8%;">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>#{{ $loop->iteration }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->created_at }}</td>
                            <td class="{{ $admin->status ? 'text-success' : 'text-danger' }}">
                                {{ $admin->status ? 'Hoạt động' : 'Không hoạt động' }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="fs-3">
        {{ $admins->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
@endsection
