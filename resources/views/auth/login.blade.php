<!DOCTYPE html>
<html>
<head>
    <title>Login - Sewa Barang Adventure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background-color:#F5E6D3;
    font-family:'Segoe UI', sans-serif;
}

/* Card */
.card{
    border:none;
    border-radius:15px;
}

/* Judul */
h4{
    color:#4E342E;
    font-weight:600;
}

.btn-custom{
    background:#D4A373;
    color:white;
    border:none;
    padding:10px;
    font-weight:500;
    transition:0.3s;
}

.btn-custom:hover{
    background:#4E342E;
    color:white;
}

/* Link */
a{
    color:#4E342E;
    text-decoration:none;
}

a:hover{
    color:#D4A373;
}


.alert-success{
    background:#D4A373;
    border:none;
    color:white;
}
</style>

</head>
<body class="d-flex align-items-center justify-content-center vh-100">>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">

                    <h4 class="text-center mb-4">Login</h4>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @error('email')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <form method="POST" action="/login">
                        @csrf

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <!-- GANTI btn-success -->
                        <button class="btn btn-custom w-100">Login</button>

                        <div class="text-center mt-3">
                            <a href="/register">Belum punya akun?</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>