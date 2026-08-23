<?php
$host="localhost";
$user="root";
$pass="";
$db="branches";
$conn = new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    die("Database Error: " . $conn->connect_error);
}

$message = "";
$branchExists = false;

// إذا المستخدم كتب اسم الفرع
if(isset($_POST['branch_name'])){
    $branch_name = trim($_POST['branch_name']);

    // البحث عن الفرع
    $sql = "SELECT * FROM branches WHERE Name = '$branch_name'";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        $branchExists = true;
        $message = "✔ نجحت العملية — الفرع موجود بالفعل";
    } else {
        $branchExists = false;
        $message = "❌ الفرع غير موجود";
    }
}

// إذا المستخدم اختار إضافة الفرع
if(isset($_POST['add_branch'])){
    $newBranch = trim($_POST['branch_name']);
    $insert = "INSERT INTO branches (Name, created_at) VALUES ('$newBranch', NOW())";
    $conn->query($insert);

    header("Location: Distribution location.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>إدارة الفروع</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: #eef1f7;
        font-family: Tahoma, sans-serif;
    }
    header {
        background: #0d6efd;
        color: #fff;
        padding: 18px;
        text-align: center;
        font-size: 22px;
        font-weight: bold;
    }
    nav {
        background: #1f1f1f;
        padding: 12px;
        text-align: center;
    }
    nav a {
        color: #fff;
        margin: 0 15px;
        text-decoration: none;
        font-weight: bold;
    }
    nav a:hover {
        color: #0d6efd;
    }
    .box {
        max-width: 500px;
        margin: 60px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    footer {
        background: #1f1f1f;
        color: #fff;
        text-align: center;
        padding: 12px;
        margin-top: 40px;
    }
</style>
</head>

<body>

<header>نظام إدارة الفروع</header>

<nav>
    <a href="imported.php">الرئيسية</a>
    <a href="branches.php">الفروع</a>
    <a href="Distribution location.php">مواقع التوزيع</a>
    <a href="login.php">تسجيل الخروج</a>
</nav>

<div class="box">
    <h3 class="text-center text-primary mb-3">البحث عن فرع</h3>

    <form method="POST">
        <label class="fw-bold">اسم الفرع:</label>
        <input type="text" name="branch_name" class="form-control" required placeholder="اكتب اسم الفرع">

        <button type="submit" class="btn btn-primary w-100 mt-3">بحث</button>
    </form>

    <?php if($message != ""): ?>
        <div class="alert mt-4 <?= $branchExists ? 'alert-success' : 'alert-danger' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <?php if(!$branchExists && $message != ""): ?>
        <form method="POST">
            <input type="hidden" name="branch_name" value="<?= htmlspecialchars($branch_name) ?>">
            <button type="submit" name="add_branch" class="btn btn-success w-100 mt-3">
                هل تود إضافة هذا الفرع؟
            </button>
        </form>
    <?php endif; ?>
</div>

<footer>
    © 2026 جميع الحقوق محفوظة — نظام إدارة الفروع
</footer>

</body>
</html>
