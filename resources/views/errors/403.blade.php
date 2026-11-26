.<DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ __('Akses Ditolak — E-Zakat') }}</title>
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body {
    font-family: 'Poppins', system-ui, sans-serif;
    min-height:100vh; display:flex; align-items:center; justify-content:center;
    background: radial-gradient(circle at 30% 20%, #1d5b37, #0d2417 70%);
    color:#f1ead9; padding:24px;
  }
  .card {
    max-width:460px; width:100%; text-align:center;
    background: rgba(255,255,255,0.06);
    border:1px solid rgba(230,179,86,0.4);
    border-radius:24px; padding:44px 32px;
    box-shadow: 0 24px 60px -24px rgba(0,0,0,0.6);
    backdrop-filter: blur(12px);
  }
  .code { font-size:64px; font-weight:800; color:#e2b356; line-height:1; }
  .title { font-size:20px; font-weight:700; margin-top:12px; }
  .msg { margin-top:10px; font-size:14px; color:#cfe0d4; line-height:1.6; }
  a.btn {
    display:inline-flex; align-items:center; gap:8px;
    margin-top:24px; background:#e2b356; color:#12301f;
    font-weight:700; font-size:14px; text-decoration:none;
    padding:12px 26px; border-radius:999px; transition:transform .15s ease, filter .15s ease;
  }
  a.btn:hover { filter:brightness(1.07); transform:translateY(-1px); }
</style>
</head>
<body>
  <div class="card">
    <div class="code">403</div>
    <div class="title">{{ __('Akses Ditolak') }}</div>
    <div class="msg">{{ $exception ? $exception->getMessage() : __('Anda tidak memiliki izin untuk mengakses halaman ini.') }}</div>
    <a class="btn" href="{{ url('/dashboard') }}">↩ {{ __('Kembali ke Dashboard') }}</a>
  </div>
</body>
</html>