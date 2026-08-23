<?php
$host="localhost";    //متغيرات الاتصال بقاعدة البيانات
$user="root";
$pass="";
$db="branches";
$conn=new mysqli($host,$user,$pass,$db);//يتم انشاء اتصال بقاعدة البيانات باستخدام كلاس اسمهmysqli
if($conn->connect_error){//هنا يتم التحقق اذا الاتصال فشل
    die("error in the date base");//تظهر الرسالة اذا فشل الاتصال
}
$search=isset($_GET['search'])?$_GET['search']:"";//searchاستقبال اذا المستخدم كتب شئ في 
$sort=isset($_GET['sort'])?$_GET['sort']:"export_date";//نحدد طريقة الترتيب
$allowedsort=["export_date","branch_name"];//نحدد الاعمدة المسموح ترتيبها
if(!in_array($sort,$allowedsort)){//شرط يمنع المستخدم اذا حاول ادخال غير مرغوب بها
$sort="export_date";
}

$sql="SELECT * FROM exports WHERE branch_name LIKE '%$search%' ORDER BY $sort DESC";//اختيار كل البيانات من الجدول وترتيب النتائج 
$result=$conn->query($sql);//يتم ارسال الاستعلام الى sql
if(!$result){//اذا حدث خطا في sqlيتم عرض الخطا الحقيقي
die(" error in the sql :".$conn->error);

}

?>
<?php
$host="localhost";
$user="root";
$pass="";
$bd="branches";
$conn= new mysqli($host,$user,$pass,$db);
if($conn->connect_error){
    die("error in the date base");
}
if(isset($_POST['add'])){
    $branch=$_POST['branch_name'];
    $date=$_POST['export_date'];
    $sql="INSERT INTO exports (branch_name,export_date) VALUES('$branch','$date')";
}
if($conn->query($sql)){
    echo"تمت الاضافة";
}else{
    echo"error in the sql".$conn->error;
}
?>
<form method="post">
    <input type="text" name="branch_name" placeholder="اسم الفرع" required>
    <input type="date" name="export_date" required>
    <button type="submit" name="add"> اضافة</button>
</form>

