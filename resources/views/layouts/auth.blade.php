<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Biblio') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
            box-sizing: border-box;
            margin: 0;
            position: relative;
        }

        /* Background Image with Blur */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/img/bg-auth.jpg') no-repeat center center;
            background-size: cover;
            filter: blur(8px);
            /* Blur effect requested by user */
            z-index: -1;
            transform: scale(1.1);
            /* Prevent blur edges from showing */
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            /* Slightly more transparent */
            backdrop-filter: blur(15px);
            /* Stronger glass effect */
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 2.5rem;
            width: 90%;
            max-width: 800px;
            /* Wider for 2 cols */
            position: relative;
            z-index: 10;
            margin: auto;
        }

        .form-control-glass {
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            padding: 12px 16px;
            width: 100%;
            box-sizing: border-box;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            outline: none;
            color: #333;
        }

        .form-control-glass:focus {
            background: rgba(255, 255, 255, 0.9);
            border-color: #1A5C4E;
            box-shadow: 0 0 0 3px rgba(26, 92, 78, 0.1);
        }

        .btn-primary-glass {
            background: #1A5C4E;
            /* Dark Green from UI */
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            width: 100%;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-primary-glass:hover {
            background: #14453b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(20, 69, 59, 0.3);
        }

        .auth-logo {
            font-size: 2rem;
            font-weight: 700;
            color: #1A5C4E;
            text-align: center;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .auth-subtitle {
            text-align: center;
            color: #444;
            /* Darker for better contrast on glass */
            font-size: 0.9rem;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #222;
            /* Darker text */
            font-weight: 600;
        }

        .input-icon {
            color: #666;
            transition: all 0.3s ease;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #444;
        }

        .auth-footer a {
            color: #1A5C4E;
            /* Blue link color */
            text-decoration: none;
            font-weight: 700;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .active-icon {
            color: #1A5C4E !important;
            filter: drop-shadow(0 0 5px rgba(26, 92, 78, 0.5));
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <!-- Background is handled by body::before -->

    <div class="glass-card">
        @yield('content')
    </div>
</body>

</html>