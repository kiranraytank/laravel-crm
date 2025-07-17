<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel CRM') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles (optional) -->
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Nunito', sans-serif;
        }
        .container {
            max-width: 1100px;
            margin-top: 30px;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .container-nav {
            background: #43587f !important;
        }
        table th, table td {
            vertical-align: middle;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .navbar-dark .navbar-nav .nav-link {
            color: #fff;
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #ffd700; /* Optional: gold on hover */
        }

    </style>

    <script>
        window.laravelRoutes = {
            contactsStore: "{{ route('contacts.store') }}",
            contactsIndex: "{{ route('contacts.index') }}",
            mergeModal: "{{ route('contacts.merge.modal') }}",
            mergeFinal: "{{ route('contacts.merge') }}",
            mergePage: "{{ route('contacts.merge.form') }}" // ✅ Add this line
        };
    </script>

    <script>
        window.csrfToken = "{{ csrf_token() }}";
    </script>


    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary">
            <div class="container container-nav">
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel CRM') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown"
                                    class="nav-link dropdown-toggle text-white"
                                    href="#"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                        {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @auth
                                        @if(auth()->user()->isAdmin())
                                            <li>
                                                <a class="dropdown-item" href="{{ route('custom_fields.index') }}">Manage Custom Fields</a>
                                            </li>
                                        @endif
                                    @endauth
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>

                            </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

    
        <main class="container py-4">
            <div id="alertMessage"></div>
            @yield('content')
        </main>

    </div>


</body>
</html>
