<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- CSRF Token --}}
    <title>Quan Ly Tai Khoan</title>
</head>
{{-- Bootstrap CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
{{-- FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
{{-- CSS --}}
<link rel="stylesheet" href="{{ asset('css/silder_admin.css') }}">

<body>
    <div style="position: fixed; width: 100%; z-index: 1000">
        @include('admin.blocks.header')
    </div>
    <div style="position: fixed; z-index: 900">
        @include('admin.blocks.silder')
    </div>
    <div class="content" style="margin-left: 250px; margin-top: 60px; padding: 20px">
        @yield('content_admin')
    </div>
    <div style="position: fixed; width: 100%; bottom: 0; z-index: 1000">
        @include('admin.blocks.footer')
    </div>
</body>
{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- jQuery  --}}
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- sweetalert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@yield('js_admin')
</html>
