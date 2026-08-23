<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Distribution Location</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #eef1f7;
            font-family: Tahoma, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header */
        header {
            background: #0d6efd;
            color: #fff;
            padding: 18px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
        }

        /* Navbar */
        nav {
            background: #1f1f1f;
            padding: 12px 20px;
            display: flex;
            justify-content: center;
            gap: 25px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
        }

        nav a:hover {
            color: #0d6efd;
        }

        /* Main Box */
        .box {
            max-width: 450px;
            margin: 80px auto;
            background: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        .box h2 {
            margin-bottom: 25px;
            color: #0d6efd;
            font-weight: bold;
        }

        .btn-lg {
            padding: 14px;
            font-size: 18px;
            border-radius: 10px;
        }

        .btn-outline-dark {
            margin-top: 10px;
        }

        /* Footer */
        footer {
            background: #1f1f1f;
            color: #fff;
            text-align: center;
            padding: 12px;
            margin-top: 40px;
            font-size: 14px;
        }
    </style>
</head>

<body>

<!-- Header -->
<header>
    نظام توزيع الفروع
</header>

<!-- Navbar -->
<nav>
    <a href="imported.php">الرئيسية</a>
    <a href="Distribution location.php">مواقع التوزيع</a>
    <a href="branches.php">الفروع</a>
    <a href="login.php">تسجيل الخروج</a>
</nav>

<!-- Main Content -->
<div class="box">
    <h2>Distribution Location</h2>

    <form action="Distribution.php">
        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Branch 1</button>
    </form>

    <form action="Distribution.php">
        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Branch 2</button>
    </form>

    <form action="Distribution.php">
        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Branch 3</button>
    </form>

    <form action="Our branches.php">
        <button type="submit" class="btn btn-outline-dark btn-lg w-100">Our Branches</button>
    </form>
</div>

<!-- Footer -->
<footer>
    © 2026 جميع الحقوق محفوظة — نظام إدارة الفروع
</footer>

</body>
</html>

