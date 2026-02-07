<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* ===== BACKGROUND ===== */
body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: radial-gradient(circle at top, #0f0f0f, #000);
    overflow:hidden;
    font-family: system-ui, sans-serif;
}

/* ===== PARTICLES ===== */
.particles span{
    position:absolute;
    width:3px;
    height:3px;
    background:rgba(255,255,255,.6);
    border-radius:50%;
    animation: float 16s linear infinite;
}
@keyframes float{
    from{ transform:translateY(110vh); opacity:0 }
    20%{ opacity:1 }
    to{ transform:translateY(-10vh); opacity:0 }
}

/* ===== CARD ===== */
.login-card{
    width:100%;
    max-width:240px;
    padding:22px 18px 24px;
    border-radius:30px;
    background:rgba(255,255,255,.13);
    backdrop-filter: blur(16px);
    box-shadow:0 20px 40px rgba(0,0,0,.7);
    animation: enter 0.9s ease forwards;
    z-index:2;
}
@keyframes enter{
    from{
        opacity:0;
        transform:translateX(-40px) scale(.96);
    }
    to{
        opacity:1;
        transform:translateX(0) scale(1);
    }
}

/* ===== TITLE ===== */
.login-title{
    font-size:15px;
    font-weight:700;
    color:#fff;
    letter-spacing:.6px;
}

/* ===== INPUT ===== */
.form-control{
    border-radius:999px;
    height:30px;
    padding:4px 12px;
    font-size:11px;
    background:rgba(255,255,255,.92);
    border:none;
    text-align:center;
    transition:.25s;
}
.form-control:focus{
    box-shadow:0 0 0 2px rgba(255,255,255,.4);
    transform:scale(1.03);
}

/* ===== BUTTON ===== */
.btn-login{
    display:block;
    margin:4px auto 0;
    width:110px;
    height:30px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    background:#fff;
    color:#000;
    position:relative;
    overflow:hidden;
    transition:.3s;
    animation: pulse 2.5s infinite;
}
@keyframes pulse{
    0%{ box-shadow:0 0 0 0 rgba(255,255,255,.4) }
    70%{ box-shadow:0 0 0 10px rgba(255,255,255,0) }
    100%{ box-shadow:0 0 0 0 rgba(255,255,255,0) }
}
.btn-login:hover{
    transform:scale(1.08);
    background:#ededed;
}

/* ===== LINK ===== */
a{
    font-size:10px;
    color:#ddd;
    text-decoration:none;
}
a:hover{ text-decoration:underline }
</style>
</head>
<body>

<!-- PARTICLES -->
<div class="particles">
    <span style="left:12%"></span>
    <span style="left:28%"></span>
    <span style="left:44%"></span>
    <span style="left:60%"></span>
    <span style="left:76%"></span>
    <span style="left:90%"></span>
</div>

<!-- LOGIN CARD -->
<div class="login-card text-center">
    <div class="login-title mb-3">ADMIN LOGIN</div>

    @if(session('error'))
        <div class="alert alert-danger py-1 small">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="mb-2">
            <input type="email" name="email" class="form-control"
                   placeholder="email admin" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control"
                   placeholder="kata sandi" required>
        </div>

        <button class="btn btn-login">
            LOGIN
        </button>
    </form>

    <div class="mt-2">
        <a href="/">kembali ke user</a>
    </div>
</div>

</body>
</html>
