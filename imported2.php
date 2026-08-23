<?php
ob_start();
if($_SERVER["REQUEST_METHOD"]=="POST"){
$nameofimported=$_POST['nameofimported']??"";
$Quantity=$_POST['Quantity']??"";
$import=$_POST['import']??"";
$Cost=$_POST['Cost']??"";
$date=$_POST['date']??"";
if(!empty($nameofimported)&& !empty($Quantity)&&!empty($import)&& !empty($Cost) &&!empty($date)){
header("location:imported.php");
exit;

}else{

echo"error in the data";
}


}
ob_end_flush();
?>