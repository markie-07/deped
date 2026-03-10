<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.profile-content')
</head>
<body>
    @include('partials.sidebar')

    <main class="main-content">
        @include('partials.navigation')
        <div class="content-body">
            @include('partials.profile-body')
        </div>
    </main>

    @include('partials.profile-scripts')
</body>
</html>
