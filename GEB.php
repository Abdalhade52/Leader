<!DOCTYPE html>
<html lang="ar">
    <head>
        <meta charset="UTF-8">
        <title>ساب وتخزين الربح</title>
</head>
<body>


<form method="post">
<input tupe="number" name="Quantity" step="1" placeholder="ادخل الكمية"required>
<button type="submit">احسب وخزن</button>
</form>
<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
$item_code =$_POST['itemcode']??'';
$item_name=$_POST['itemname']??'';
$category=$_POST['category']??'';
$unit=$_POST['unit']??'';
$quantity=$_POST['quantity']??'';
$cost_price=$_POST['costprice']??'';
$sell_price=$_POST['sellprice']??'';
$exported_date=$_POST['exporteddate']??'';
echo"    كود الصنف:  ".htmlspecialchars($item_code)."<br>";
echo"    داسم الصنف:  ".htmlspecialchars($item_name)."<br>";
echo"    التصنيف:  ".htmlspecialchars($category)."<br>";
echo"   الوحدة:  ".htmlspecialchars($unit)."<br>";
echo"    الكمية:  ".htmlspecialchars($quantity)."<br>";
echo"   سعر التكلفة:  ".htmlspecialchars($cost_price)."<br>";
echo"    سعر البيع:  ".htmlspecialchars($sell_price)."<br>";
echo"    تاريخ الانتهاء:  ".htmlspecialchars($exported_date)."<br>";

}else{

echo"لم يتم تعبئة النموذج";

}




ob_end_flush();
?>


