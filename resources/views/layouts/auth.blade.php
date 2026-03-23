<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Client Portal')</title>

    {{-- Tailwind --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        /* Glass effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: black;
        }

        body {
            background: linear-gradient(135deg, #1E3A8A, #3B82F6, #60A5FA);
            background-size: cover;
            background-position: center;
            background: url('/images/bg.png') no-repeat center center fixed;
            background-size: cover;
        }

        /* Center container smoothly */
        .center-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
    </style>
</head>

<body class="text-gray-100">

    <div class="center-wrapper">

        <div class="w-full max-w-lg p-8 glass-card rounded-2xl shadow-xl">

            {{-- LOGO --}}
            <div class="flex justify-center mb-6">
                <img src="/images/logo.png" 
                     alt="Portal Logo"
                     class="w-20 h-20 object-contain drop-shadow-lg">
            </div>

            {{-- PAGE TITLE --}}
            @hasSection('title')
                <h1 class="text-center text-2xl font-bold text-white mb-4 drop-shadow">
                    @yield('title')
                </h1>
            @endif

            {{-- MAIN CONTENT --}}
            <div class="text-black-200">
                @yield('content')
            </div>

        </div>
    </div>

</body>
</html>
