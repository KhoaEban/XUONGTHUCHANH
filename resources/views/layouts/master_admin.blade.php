<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quản trị Admin')</title>

</head>

<body>
    @include('layouts.sidebar_admin')



    {{-- <script>
        $(document).ready(function() {
            $('.ui.dropdown').dropdown(); // Kích hoạt dropdown Semantic UI
        });
    </script> --}}
</body>

</html>
