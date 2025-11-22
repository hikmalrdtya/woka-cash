<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="favicon.ico">
    <script>
        if (localStorage.getItem("dark-mode") === "true") {
            document.documentElement.classList.add("dark");
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>@yield('title')</title>
</head>

<body>
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <main class="page-content flex-1 p-4 lg:p-8 overflow-x-auto overflow-hidden">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/bundle.js') }}"></script>
</body>

</html>
