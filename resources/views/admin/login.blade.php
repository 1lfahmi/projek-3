<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1d3557, #457b9d);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .motion-bg {
  position: fixed;
  inset: 0;
  z-index: -4;
  background:
      radial-gradient(circle at 20% 30%, rgba(0, 0, 255, 0.35), transparent 40%),
      radial-gradient(circle at 80% 70%, rgba(0, 150, 255, 0.25), transparent 45%),
      linear-gradient(120deg, #020024, #000428, #004e92);
  animation: gradientMove 20s ease-in-out infinite alternate;
}

@keyframes gradientMove {
  0% { background-position: 0% 50%, 100% 50%, 0% 50%; }
  100% { background-position: 100% 50%, 0% 50%, 100% 50%; }
}

/* ============ BACKGROUND IMAGE ============ */
#Animated-Image {
  position: fixed;
  inset: 0;
  width: 100vw;
  height: 100vh;
  object-fit: cover;
  z-index: -5;
  filter: brightness(40%) blur(1px);
  animation: slowZoom 30s ease-in-out infinite alternate;
}

@keyframes slowZoom {
  from { transform: scale(1); }
  to { transform: scale(1.08); }
}

/* ============ NAVBAR ============ */
.navbar {
  position: fixed;
  top: 0;
  width: 100%;
  padding: 12px 25px;
  background: rgba(0,0,0,0.7);
  display: flex;
  justify-content: space-between;
  align-items: center;
  z-index: 10;
}

.navbar-links {
  display: flex;
  list-style: none;
  gap: 20px;
}

.navbar-links a {
  color: white;
  text-decoration: none;
}

/* ============ LINE ANIMATION ============ */
.lines {
  position: fixed;
  inset: 0;
  z-index: -1;
  display: flex;
  justify-content: space-around;
}

.line {
  width: 3px;
  height: 120px;
  background: linear-gradient(
      to bottom,
      transparent,
      rgba(0, 150, 255, 0.9),
      transparent
  );
  animation: fall 6s linear infinite;
  opacity: 0.8;
  filter: drop-shadow(0 0 10px rgba(0,150,255,0.8));
}

/* Variasi */
.line:nth-child(1) { animation-duration: 4s; }
.line:nth-child(2) { animation-duration: 6s; height: 180px; }
.line:nth-child(3) { animation-duration: 5s; }
.line:nth-child(4) { animation-duration: 7s; height: 220px; }
.line:nth-child(5) { animation-duration: 3.5s; }
.line:nth-child(6) { animation-duration: 6.5s; height: 160px; }
.line:nth-child(7) { animation-duration: 4.5s; }
.line:nth-child(8) { animation-duration: 7.5s; height: 200px; }

@keyframes fall {
  0% {
      transform: translateY(-150%);
      opacity: 0;
  }
  20% {
      opacity: 1;
  }
  100% {
      transform: translateY(120vh);
      opacity: 0;
  }
}

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 15px;
            background: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .login-title {
            font-weight: bold;
            color: #1d3557;
        }
        .btn-login {
            background-color: #1d3557;
            color: white;
        }
        .btn-login:hover {
            background-color: #16324f;
        }
    </style>
</head>
<body>

<div class="lines">
    <span class="line"></span>
    <span class="line"></span>
    <span class="line"></span>
    <span class="line"></span>
    <span class="line"></span>
    <span class="line"></span>
    <span class="line"></span>
    <span class="line"></span>
</div>

<div class="login-card">
    <h3 class="text-center login-title mb-4">🔐 Admin Login</h3>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
        </div>

        <button type="submit" class="btn btn-login w-100">Login</button>
    </form>

    <div class="text-center mt-3">
        <a href="/" class="text-decoration-none">⬅ Kembali ke halaman user</a>
    </div>
</div>

</body>
</html>
