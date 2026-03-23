<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP - ImperialVilla</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('{{ asset('images/bg.png') }}') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            position: fixed;
            top:0; left:0;
            width:100%; height:100%;
            background: rgba(0,0,0,0.55);
            z-index:0;
        }

        .otp-card {
            max-width: 430px;
            margin: 70px auto;
            background: rgba(255,255,255,0.97);
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.35);
            position: relative;
            z-index: 10;
            animation: fadeIn 0.7s ease-out;
            text-align: center;
        }

        @keyframes fadeIn {
            from { opacity:0; transform: translateY(20px); }
            to { opacity:1; transform: translateY(0); }
        }

        @keyframes shake {
            20% { transform: translateX(-4px); }
            40% { transform: translateX(4px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }

        .shake { animation: shake 0.4s; }

        .otp-container {
            display: flex;
            justify-content: center;
            margin: 25px 0;
        }

        .otp-input {
            width: 50px;
            height: 55px;
            margin: 0 6px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            border-radius: 12px;
            border: 2px solid #bbbbbb;
            transition: 0.25s;
            background:white;
        }

        .otp-input:focus {
            border-color: #004aef;
            transform: scale(1.12);
            box-shadow: 0 0 10px rgba(0,74,239,0.4);
        }

        .valid { border-color: #0ac24a !important; }
        .invalid { border-color: #ff0033 !important; }

        .btn {
            background:#004aef;
            color:white;
            padding:14px;
            border:none;
            width:100%;
            border-radius:10px;
            font-size:17px;
            font-weight:bold;
            cursor:pointer;
            transition:0.25s;
        }

        .btn:hover { transform: translateY(-2px); background:#0036b3; }

        .timer {
            margin-top: 20px;
            font-size:18px;
            color:#004aef;
            font-weight:bold;
        }

        .resend-btn {
            display:none;
            margin-top:14px;
            font-size:15px;
            color:#004aef;
            text-decoration: underline;
            font-weight:bold;
            cursor:pointer;
        }

        .help-box {
            margin-top: 18px;
            font-size: 14px;
            color:#666;
            cursor:pointer;
        }

        .help-panel {
            display:none;
            background:#f8f8f8;
            padding:15px;
            margin-top:10px;
            border-radius:10px;
            font-size:14px;
            color:#444;
            border-left:4px solid #004aef;
        }

        /* countdown progress bar */
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #d7dffc;
            border-radius: 20px;
            margin-top: 14px;
            overflow:hidden;
        }

        .progress-inner {
            height: 100%;
            width: 100%;
            background: #004aef;
            transition: width 1s linear;
        }

    </style>
</head>

<body>

<div class="overlay"></div>

<div class="otp-card" id="otpCard">

    <h2 style="color:#004aef;">Verify OTP</h2>
    <p style="font-size:14px;">Enter the 6-digit code sent to <strong>{{ $email }}</strong></p>

    @if(session('error'))
        <div class="error-box" style="
            background:#ffe3e3; border-left:4px solid #cc0000;
            padding:12px; border-radius:10px; margin-bottom:15px;">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <!-- OTP boxes -->
        <div class="otp-container">
            @for($i=1; $i<=6; $i++)
                <input type="text" maxlength="1" class="otp-input" id="otp{{ $i }}"
                       inputmode="numeric" pattern="[0-9]*">
            @endfor
        </div>

        <button type="submit" class="btn">Verify OTP</button>

        <!-- Countdown -->
        <div class="timer">
            ⏳ Code expires in <span id="countdown">60</span>s
        </div>

        <div class="progress-bar">
            <div class="progress-inner" id="progressInner"></div>
        </div>

        <!-- Resend Button -->
        <div id="resendWrapper" style="margin-top:10px; display:none;">
            <form method="POST" action="{{ route('otp.resend') }}">
                @csrf
                <button type="submit" class="resend-btn">🔄 Resend OTP</button>
            </form>
        </div>

        <!-- Help -->
        <div class="help-box" onclick="toggleHelp()">❓ Didn't receive OTP?</div>

        <div class="help-panel" id="helpPanel">
            • Check your spam or junk folder.<br>
            • Make sure your email is correct.<br>
            • Wait for the timer to finish and tap **Resend OTP**.<br>
            • Ensure your network connection is stable.<br>
        </div>

    </form>

</div>

<script>
    const inputs = document.querySelectorAll(".otp-input");

    // OTP animation + validation
    inputs.forEach((input, index) => {
        input.addEventListener("input", () => {
            input.value = input.value.replace(/[^0-9]/g, "");

            if (input.value !== "") {
                input.classList.add("valid");
                if (index < inputs.length - 1) inputs[index + 1].focus();
            } else {
                input.classList.add("invalid");
            }
        });

        input.addEventListener("keydown", e => {
            if (e.key === "Backspace" && index > 0 && !input.value) {
                inputs[index - 1].focus();
            }
        });
    });

    // Merge OTP before submit
    document.getElementById("otpForm").addEventListener("submit", function(){
        let otp = "";
        inputs.forEach(i => otp += i.value);
        const hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = "otp";
        hidden.value = otp;
        this.appendChild(hidden);
    });

    // Countdown logic
    let timeLeft = 60;
    const timer = document.getElementById("countdown");
    const resend = document.getElementById("resendWrapper");
    const progress = document.getElementById("progressInner");

    const interval = setInterval(() => {
        timeLeft--;
        timer.textContent = timeLeft;
        progress.style.width = (timeLeft * 100 / 60) + "%";

        if (timeLeft <= 10) timer.style.color = "#ff0033";

        if (timeLeft <= 0) {
            clearInterval(interval);
            timer.textContent = "0";
            progress.style.width = "0%";
            resend.style.display = "block";
        }
    }, 1000);

    // Shake animation when error
    @if(session('error'))
        document.getElementById("otpCard").classList.add("shake");
    @endif

    // Help toggle
    function toggleHelp(){
        const panel = document.getElementById("helpPanel");
        panel.style.display = panel.style.display === "block" ? "none" : "block";
    }
</script>

</body>
</html>
