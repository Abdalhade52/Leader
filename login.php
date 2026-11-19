<?php
require __DIR__.'/app.php';
if(!empty($_SESSION['user_id'])){require_login();header('Location: dashboard.php');exit;}
$loginError='';
if(($_SERVER['REQUEST_METHOD']??'GET')==='POST'){
 verify_csrf();$emailAddress=strtolower(trim((string)($_POST['email']??'')));$plainTextPassword=(string)($_POST['password']??'');
 $userStatement=db()->prepare('SELECT id,shop_id,role,branch_id,password_hash FROM users WHERE email=? LIMIT 1');$userStatement->execute([$emailAddress]);$userRecord=$userStatement->fetch();
 if($userRecord&&password_verify($plainTextPassword,$userRecord['password_hash'])){session_regenerate_id(true);$_SESSION['user_id']=(int)$userRecord['id'];$_SESSION['csrf_token']=bin2hex(random_bytes(32));header('Location: dashboard.php');exit;}
 $loginError='البريد الإلكتروني أو كلمة المرور غير صحيحة.';
}
?><!doctype html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>دخول - مدار للتوزيع</title><link rel="stylesheet" href="css/app.css"></head><body class="login-page"><main class="login-card"><h1>مدار للتوزيع</h1><?php if($loginError):?><p class="alert"><?=e($loginError)?></p><?php endif?><form method="post"><?=csrf_field()?><label>البريد الإلكتروني<input type="email" name="email" required autocomplete="username" maxlength="254"></label><label>كلمة المرور<input type="password" name="password" required autocomplete="current-password"></label><button>دخول</button></form></main></body></html>

