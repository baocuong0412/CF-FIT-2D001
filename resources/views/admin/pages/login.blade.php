<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
</head>
{{-- Bootstrap CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<body style="margin: 0; padding: 0; box-sizing: border-box;">

    <img src="{{ asset('images/image.jpg') }}" alt="HinhDangNhap"
        style="width: 100%; height: 907.2px; object-fit: cover;">

    <div>
        <div
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border-radius: 10px; width: 500px;">
            <h1 style="text-align: center;">Đăng Nhập</h1>
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('admin.login') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name" class="mb-3">Name</label>
                    <input type="name" class="form-control mb-3" id="name" name="name">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="password" class="mb-3">Password</label>
                    <input type="password" class="form-control mb-3" id="password" name="password">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-4">Đăng nhập</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
