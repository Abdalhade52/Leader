
<?php
session_start();
$correctUsername=$_SESSION['username']??"Admin";
$correctPassword=$_SESSION['password']??"123456";
if($_SERVER["REQUEST_METHOD"]=="POST"){
$username=$_POST['username']??"";
$password=$_POST['password']??"";
if($username===$correctUsername&&$password===$correctPassword){
echo"تم تسجيل الدخول";
header("location:imported.php");

}else{
  echo"اسم المستخدم او كلمة السر خطا";
}

}


?>












