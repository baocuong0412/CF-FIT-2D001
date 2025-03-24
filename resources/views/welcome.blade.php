<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Can Ho Cho Thue</title>
</head>
{{-- Bootstrap CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
{{-- FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
{{-- Asset CSS --}}
<link rel="stylesheet" href="{{ asset('css/slider.css') }}">
<link rel="stylesheet" href="{{ asset('css/logo.css') }}">

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<body>

    @include('include.header')
    @if (!request()->is('contact') && !request()->is('price-list') && !request()->routeIs('detail'))
        <div style="margin-top: 94px">
            @include('include.slider')
        </div>
    @endif

    @yield('content')

    @include('include.footer')

</body>
{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- jQuery  --}}
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@yield('js')
<script>
    $(document).ready(function() {
        $(window).scrollTop(0);
    });
</script>

</html>
