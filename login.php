<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        body {
            background: #f0f2f5;
            font-family: "Tahoma", sans-serif;
        }

        /* Header */
        header {
            background: #0d6efd;
            color: #fff;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Navbar */
        nav {
            background: #212529;
        }
        nav a {
            color: #fff !important;
            margin-right: 15px;
        }

        /* Login Box */
        .wrapper {
            width: 380px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin: 60px auto;
        }

        .wrapper h1 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
            color: #333;
        }

        .input-box {
            position: relative;
            margin-bottom: 20px;
        }

        .input-box input {
            width: 100%;
            padding: 12px 40px 12px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        .input-box input:focus {
            border-color: #0d6efd;
        }

        .input-box i {
            position: absolute;
            right: 12px;
            top: 12px;
            font-size: 20px;
            color: #777;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            background: #0d6efd;
            color: #fff;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #0b5ed7;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            color: #0d6efd;
            text-decoration: none;
        }

        /* Footer */
        footer {
            background: #212529;
            color: #fff;
            text-align: center;
            padding: 12px;
            margin-top: 40px;
        }
    </style>
</head>

<body>

<!-- Header -->
<header>
    <h2>Welcome to the System</h2>
</header>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark px-3">
    <a class="navbar-brand" href="#">Home</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="#">Help</a></li>
            <li class="nav-item"><a class="nav-link" href="#">About</a></li>
        </ul>
    </div>
</nav>

<!-- Login Box -->
<div class="wrapper">
    <form action="project.php" method="POST">
        <h1>Login</h1>

        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
            <i class='bx bxs-user'></i>
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt'></i>
        </div>

        <button type="submit" class="btn-login">Log in</button>

        <div class="register-link">
            <p>Forgot your password? <a href="#">Reset</a></p>
        </div>
    </form>
</div>

<!-- Footer -->
<footer>
    © 2026 All Rights Reserved
</footer>

</body>
</html>



