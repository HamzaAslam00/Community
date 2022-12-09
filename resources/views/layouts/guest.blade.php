<!DOCTYPE html>
<html lang="zxx" class="js">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{config('app.name')}} @yield('title')</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fav Icon  -->
        <link rel="shortcut icon" href="{{ asset('assets/images/frontend/favicon.png') }}" type="image/png">

            <!-- Scripts -->
            @vite([
                'resources/css/app.css',
                'resources/css/theme/dashlite.css',
                'resources/css/theme/theme.css',
                'resources/js/app.js',
                'resources/js/theme/bundle.js',
                'resources/js/theme/scripts.js',
            ])
    </head>
    <body class="nk-body bg-lighter npc-default pg-auth">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <!-- wrap @s -->
                <div class="nk-wrap nk-wrap-nosidebar">
                    <!-- content @s -->
                    <div class="nk-content ">
                        @yield('content')
                    </div>
                    <!-- wrap @e -->
                </div>
                <!-- content @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    </body>
</html>