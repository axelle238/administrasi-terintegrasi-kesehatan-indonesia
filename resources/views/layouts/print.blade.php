<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Label - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body { background: white; }
            .no-print { display: none; }
            .print-area { margin: 0; padding: 0; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    {{ $slot }}
    <script>
        window.onload = function() {
            // Auto print if needed, or leave to user
            // window.print();
        }
    </script>
</body>
</html>
