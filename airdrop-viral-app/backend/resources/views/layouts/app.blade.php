<!DOCTYPE html>
<html lang="en" class="bg-base-200">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'AirDrop Tinder') }}</title>
    <!-- Tailwind + DaisyUI CDN -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.57.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen flex flex-col">
    <main class="flex-1 container mx-auto p-4">
        @yield('content')
    </main>
</body>
</html>