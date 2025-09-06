<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Inline script to detect system dark mode preference and apply it immediately --}}
    <script>
        (function() {
            const appearance = '{{ $appearance ?? 'system' }}';

            if (appearance === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            }
        })();
    </script>

    {{-- Inline style to set the HTML background color based on our theme in app.css --}}
    <style>
        html {
            background-color: oklch(1 0 0);
        }

        html.dark {
            background-color: oklch(0.145 0 0);
        }
  

    </style>

    <title inertia>{{ config('app.name', 'Laravels') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />


    @routes
    @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<div class="max-w-screen-2xl mx-auto">

    <body class="font-sans antialiased">
        @inertia
    </body>
</div>
<script src="https://cdn.jsdelivr.net/npm/preline/dist/index.js"></script>
<!-- Apexcharts -->
<script src="https://cdn.jsdelivr.net/npm/lodash/lodash.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/preline/dist/helper-apexcharts.js"></script>

{{-- <style scoped>
    .custom-modal .el-dialog {
        max-width: 20vw;
        width: auto;
        /* Let the modal resize based on content */
    }

    .custom-upload {
        width: 100%;
        /* Ensure the upload area takes up full width */
    }

    .el-input,
    .el-upload {
        width: 100%;
        /* Make sure all inputs and upload sections scale properly */
    }

    /* Custom Upload Styles */
    .custom-upload ::v-deep(.el-upload-list__item) {
        width: 100%;
        height: 80px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .confirm-dialog {
  background-color: rgba(255, 255, 255, 0.7); /* Less bright white */
}

</style> --}}

</html>
