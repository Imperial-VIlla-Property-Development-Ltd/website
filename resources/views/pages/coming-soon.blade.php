<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Coming Soon | DoyinTech Portal</title>

    <!-- Google Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #004aad, #0078ff);
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .coming-container {
            text-align: center;
            max-width: 700px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 50px 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.25);
            animation: fadeIn 1.2s ease-in-out;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .countdown {
            margin: 30px 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .countdown div {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 15px;
            min-width: 90px;
        }

        .countdown span {
            display: block;
            font-size: 2rem;
            font-weight: 700;
        }

        .countdown small {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .btn-launch {
            background-color: #fff;
            color: #004aad;
            font-weight: 600;
            border-radius: 50px;
            padding: 12px 40px;
            transition: all 0.3s ease;
        }

        .btn-launch:hover {
            background-color: #004aad;
            color: #fff;
            transform: scale(1.05);
        }

        footer {
            margin-top: 40px;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(30px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="coming-container">
        <img src="{{ asset('images/portal-icon.png') }}" alt="Portal Icon" width="80" class="mb-3">
        <h1>Portal Launching Soon 🚀</h1>
        <p>We’re working on something exciting! The new <strong>DoyinTech Client & Staff Portal</strong> will be live shortly.</p>

        <div class="countdown" id="countdown">
            <div>
                <span id="days">00</span>
                <small>Days</small>
            </div>
            <div>
                <span id="hours">00</span>
                <small>Hours</small>
            </div>
            <div>
                <span id="minutes">00</span>
                <small>Minutes</small>
            </div>
            <div>
                <span id="seconds">00</span>
                <small>Seconds</small>
            </div>
        </div>

        <a href="/" class="btn btn-launch">Back to Homepage</a>

        <footer class="mt-4">
            <p>&copy; {{ date('Y') }} DoyinTech. All Rights Reserved.</p>
        </footer>
    </div>

    <script>
        // Countdown timer (example: launch in 30 days)
        const launchDate = new Date();
        launchDate.setDate(launchDate.getDate() + 30);

        const countdown = () => {
            const now = new Date().getTime();
            const gap = launchDate - now;

            const second = 1000;
            const minute = second * 60;
            const hour = minute * 60;
            const day = hour * 24;

            const d = Math.floor(gap / day);
            const h = Math.floor((gap % day) / hour);
            const m = Math.floor((gap % hour) / minute);
            const s = Math.floor((gap % minute) / second);

            document.getElementById('days').innerText = d;
            document.getElementById('hours').innerText = h;
            document.getElementById('minutes').innerText = m;
            document.getElementById('seconds').innerText = s;
        };

        setInterval(countdown, 1000);
    </script>
</body>
</html>
