






<?php
$servername="localhost";
$username="root";
$password="";
$dbname="shop";
$conn= new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){

die(      "فشل الاتصال بقاعدة البيانات".$conn->connect_error  );
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
$Quantity=isset($_POST['Quantity'])? floatval($_POST['Quantity']) :0;
$profit=$Quantity *0.75;
$stmt=$conn->prepare("INSERT INTO  البضائع(quantity,profit) VALUES (?,?)");
$stmt->bind_param("dd",$Quantity,$profit);
if($stmt->execute()){

echo"<p> تم حفظ البيانات </p> ";
echo"<p> الربح:".htmlspecialchars($profit)."</p>";


}else{
echo"<p>  حدث خطا.</p>";

}
$stmt->close();
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>حساب وتخزين الربح</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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

        .box h3 {
            margin-bottom: 25px;
            color: #0d6efd;
            font-weight: bold;
        }

        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #0d6efd;
        }

        .btn {
            width: 100%;
            margin-top: 12px;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
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
    نظام حساب وتخزين الربح
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
    <h3>حساب وتخزين الربح</h3>

    <form method="post">
        <input type="number" name="Quantity" step="1" placeholder="ادخل الكمية" required>
        <button type="submit" class="btn btn-primary">احسب وخزن</button>
    </form>

    <input type="date" name="d" class="form-control mt-3" placeholder="ادخل التاريخ المتوقع للتوصيل">

    <form action="imported.php">
        <button class="btn btn-secondary">الرجوع للشاشة الرئيسية</button>
    </form>

    <form action="GEB2.php">
        <button type="submit" class="btn btn-success">اضافة بضائع اخرى</button>
    </form>

    <form action="Distribution location.php">
        <button type="submit" class="btn btn-dark">الرجوع للخلف</button>
    </form>
</div>

<!-- Footer -->
<footer>
    © 2026 جميع الحقوق محفوظة — نظام إدارة المخزون
</footer>

</body>
</html>
