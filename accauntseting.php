<?php
session_start();
$correctEmail=$_SERVER['email']??"admin@example.com";
$correctPassword=$_SERVER['password']??"123456";
if($_SERVER["REQUEST_METHOD"]=="POST"){
$email=$_POST['email']??"";
$password=$_POST['password']??"";
if($email===$correctEmail&&$password===$correctPassword){
    echo"تم تسجيل الدخول";
    exit;
}else{
    echo"البيانات غير مسجلة";
    exit;
}

}

?>
