<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>إضافة بيانات الأصناف المستوردة</title>

<style>
    body {
        font-family: Tahoma, sans-serif;
        background: #eef1f7;
        padding: 0;
        margin: 0;
    }

    /* Header */
    header {
        background: #0d6efd;
        color: #fff;
        padding: 18px;
        text-align: center;
        font-size: 22px;
        font-weight: bold;
        letter-spacing: 1px;
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

    /* Main Container */
    .container {
        width: 100%;
        max-width: 600px;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        margin: 40px auto;
    }

    h3 {
        text-align: center;
        color: #0d6efd;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-top: 12px;
        font-weight: bold;
    }

    input, select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 8px;
        outline: none;
        transition: 0.3s;
    }

    input:focus, select:focus {
        border-color: #0d6efd;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #0d6efd;
        color: #fff;
        border: none;
        border-radius: 8px;
        margin-top: 20px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background: #0b5ed7;
    }

    .btn-link {
        margin-top: 20px;
        display: block;
        text-align: center;
        background: #198754;
        padding: 12px;
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
    }

    .btn-link:hover {
        background: #146c43;
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
    نظام إدارة الأصناف المستوردة
</header>

<!-- Navbar -->
<nav>
    <a href="imported.php">الرئيسية</a>
    <a href="Distribution location.php">مواقع التوزيع</a>
    <a href="branches.php">الفروع</a>
    <a href="login.php">تسجيل الخروج</a>
</nav>

<!-- Main Content -->
<div class="container">
    <h3>إضافة بيانات الأصناف المستوردة</h3>

    <form action="" method="POST">

        <label>كود الصنف:</label>
        <input type="text" name="itemcode" required>

        <label>اسم الصنف:</label>
        <input type="text" name="itemname" required>

        <label>التصنيف:</label>
        <input type="text" name="category">

        <label>وحدة القياس:</label>
        <select name="unit">
            <option value="قطعة">قطعة</option>
            <option value="كرتون">كرتون</option>
            <option value="كيلو">كيلو</option>
            <option value="لتر">لتر</option>
        </select>

        <label>الكمية المتاحة:</label>
        <input type="number" name="quantity" min="0">

        <label>سعر التكلفة:</label>
        <input type="number" name="costprice" step="0.01">

        <label>سعر البيع:</label>
        <input type="number" name="sellprice" step="0.01">

        <label>تاريخ الانتهاء:</label>
        <input type="date" name="importeddate">

        <button type="submit">حفظ الصنف</button>
    </form>

    <a href="Distribution location.php" class="btn-link">مواقع التوزيع</a>
</div>

<!-- Footer -->
<footer>
    © 2026 جميع الحقوق محفوظة — نظام إدارة المخزون
</footer>

</body>
</html>


<?php
// اتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "inventory_system");

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// حفظ البيانات
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $quantity = $_POST['quantity'];
    $costprice = $_POST['costprice'];
    $sellprice = $_POST['sellprice'];
    $importeddate = $_POST['importeddate'];

    $sql = "INSERT INTO imported (quantity, costprice, sellprice, importeddate)
            VALUES ('$quantity', '$costprice', '$sellprice', '$importeddate')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green; text-align:center; margin-top:20px;'>تم حفظ البيانات بنجاح ✔</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>خطأ: " . $conn->error . "</p>";
    }
}

// عرض البيانات
$result = $conn->query("SELECT * FROM imported");

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>الكمية</th>
            <th>سعر التكلفة</th>
            <th>سعر البيع</th>
            <th>تاريخ الانتهاء</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['quantity']."</td>
                <td>".$row['costprice']."</td>
                <td>".$row['sellprice']."</td>
                <td>".$row['importeddate']."</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p style='text-align:center; margin-top:20px;'>لا توجد بيانات لعرضها.</p>";
}
?>
</body>
</html>
