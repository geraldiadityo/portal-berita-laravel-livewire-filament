<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Portal Berita' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased">

    <livewire:components.navbar />

    <main class="min-h-screen container mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    <footer class="bg-white border-t mt-12">
        <div class="container mx-auto px-4 py-6 text-center text-gray-600">
            &copy; {{ date('Y') }} Portal Berita. All rights reserved.
        </div>
    </footer>

</body>

</html>
