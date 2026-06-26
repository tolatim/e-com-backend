<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | Admin Portal</title>
    @vite('resources/css/app.css')
</head>

<body class="h-full m-0">
    <div class="flex min-h-screen bg-slate-50">
        @include('layouts.sidebar')

        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    <!-- <footer class="bg-gray-800 text-gray-400 text-center p-4 flex-none">
        <p>&copy; 2026 Admin Portal. All rights reserved.</p>
    </footer> -->
</body>

</html>