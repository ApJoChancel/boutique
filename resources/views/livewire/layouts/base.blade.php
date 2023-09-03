<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Page Title' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body>
    {{ $slot }}
    
    <script>
        window.addEventListener('close-modal', event => {
            $('#confirmModal').modal('hide');
            $('#changeModal').modal('hide');
        });

        window.addEventListener('show-confirm', event => {
            $('#confirmModal').modal('show')
        });
        window.addEventListener('show-change', event => {
            $('#changeModal').modal('show')
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @livewireScripts
</body>
</html>