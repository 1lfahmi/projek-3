<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>3R Motor Admin Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* ===== BACKGROUND ===== */
body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: radial-gradient(circle at top, #071029, #020617 55%, #000 100%);
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
    max-width:320px;
    padding:28px 24px 28px;
    border-radius:28px;
    background:rgba(255,255,255,0.08);
    backdrop-filter: blur(20px);
    box-shadow:0 20px 55px rgba(0,0,0,0.7);
    animation: enter 0.9s ease forwards;
    z-index:2;
}

.login-brand {
    font-size: 18px;
    font-weight: 800;
    color: #eef2ff;
    margin-bottom: 18px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.login-brand span {
    color: #facc15;
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
    margin:8px auto 0;
    width:120px;
    height:36px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;
    background: linear-gradient(135deg, #2563eb, #facc15);
    color:#0f172a;
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
    <div class="login-brand">GY<span>-Techautocar</span> Admin</div>
    <div class="login-title mb-3">Silakan masuk</div>

    @if(session('error'))
        <div class="alert alert-danger py-2 small rounded-3">
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

<div class="animel">
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    <span class="anima"></span>
    
  </div>

  <div class="haha">
    <span class="hah"></span>
  </div>


  <div class="anime">
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>
    <span class="anim"></span>

</body>
</html>
