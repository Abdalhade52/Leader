
<?php     
if($_SERVER['REQUEST_METHOD']=='GET'){//يتحقق من نوع الطلب القادم هل هو get
$Profit=$_GET['Profit']??0;//   يستقبل قيمةمن المستخدم  و؟؟ تعني اذا لم تكن القيمة موجودة يضع 0بدلامنهاProfit
$Importratio=$_GET['Importratio']??0;//يستقبل قيمة واذا لم تكن موجودة يضع 0 بدلامنها Importratio
$Export=$_GET['Export']??0;// يستقبل قيمة واذا لم تكن موجودة يضع0Export
$Total_g=$_GET['Total_g']??0;// واذا لم تكن موجودة يضع 0Total_g يستقبل قيمة
$sum="";//متغير لتخزين نتيجة الحساب
$sum=$Total_g*($Profit/100);//(100/نسبة الربح)*معادلة البضائع  
echo"نسبة الربح % ".   htmlspecialchars($sum) ."<br>";//طباعة مجموع البضائع

echo "مجموع البضائع المصدرة% ".htmlspecialchars($Total_g)."<br>";//طباعة مجموع البضائع المصدرة
echo"    نسبة الاستيراد %"  .  htmlspecialchars($Importratio)."<br>";//طباعة نسبة الاستيراد
echo"نسبة التصدير للافرع%"   .htmlspecialchars($Export)."<br>";//طباعة نسبة التصدير للافرع
echo"   المطلوبة  نسبة الربح %" .htmlspecialchars($Profit)."<br>";//طباعة نسبة الربح المستهدفة

}else{
echo" error to input";//اذا لم يكن الطلب اطبع رسالة الخطا get


}



?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Statics</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

<form method="GET">

<div class="row">
  <div class="col">
     <input type="text" style="width: 400px;" name="Importratio" class="form-control" placeholder="نسبة الاستيراد">
     <input type="text" style="width: 400px;" name="Profit" class="form-control" placeholder="نسبة الربح">
  </div>

  <div class="col">
     <input type="text" style="width: 240px;" name="Total_g" class="form-control" placeholder="مجموع البضائع المصدرة">
  </div>

  <div class="col">
     <input type="text" style="width: 240px;" name="Export" class="form-control" placeholder="نسبة الربح المطلوبة">
  <input type="text" style="width: 240px;" name="Export" class="form-control" placeholder="نسبة التصدير للأفرع">
  </div>
</div>

<button class="btn btn-primary mt-3" type="submit">Submit</button>

</form>
<form action="exports.php" method="get">
<button type="submit" class="btn btn-primary btn-lg">صفحة الصادرات</button>
</form>
</body>
</html>










</html>
