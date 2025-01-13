<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title> 
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body>
    @include('layouts.navigation')
    
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>
    
    @vite(['resources/js/app.js'])
    <script src="{{ asset('js/tasks.js') }}"></script>
    <script src="{{ asset('js/document.js') }}"></script>
    <script src="{{ asset('js/folder_management.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
