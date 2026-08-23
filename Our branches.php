<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>فروع الشركة</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    body {
        background: #f0f2f5;
        padding: 30px;
        font-family: "Tajawal", sans-serif;
    }

    h2 {
        color: #0d6efd;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .branch-btn {
        width: 230px;
        padding: 14px;
        font-size: 18px;
        border-radius: 10px;
        margin: 10px;
    }

    .btn-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }

    .offcanvas-header {
        background: #0d6efd;
        color: #fff;
    }

    .offcanvas-body {
        font-size: 16px;
        line-height: 1.8;
    }

    .nav-buttons form {
        display: inline-block;
        margin: 5px;
    }

    .nav-buttons button {
        width: 150px;
        padding: 10px;
        border-radius: 8px;
    }
</style>

</head>
<body>

<h2 class="text-center">فروع الشركة</h2>

<div class="btn-container">
    <button class="btn btn-primary branch-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#branch1">الفرع الأول</button>
    <button class="btn btn-primary branch-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#branch2">الفرع الثاني</button>
    <button class="btn btn-primary branch-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#branch3">الفرع الثالث</button>
</div>

<!-- Branch 1 -->
<div class="offcanvas offcanvas-start" id="branch1">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">معلومات الفرع الأول</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <p>
      📍 الموقع: شارع الملك، وسط المدينة  
      📞 التواصل: +966 55 123 4567  
      🕒 ساعات العمل: 9:30 صباحًا - 10:00 مساءً (السبت – الخميس)
    </p>

    <button class="btn btn-success w-100 mt-3">نعم</button>
  </div>
</div>

<!-- Branch 2 -->
<div class="offcanvas offcanvas-start" id="branch2">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">معلومات الفرع الثاني</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <p>
      📍 الموقع: شارع الملك، وسط المدينة  
      📞 التواصل: +966 55 145 0015  
      🕒 ساعات العمل: 11:15 صباحًا - 11:00 مساءً (السبت – الخميس)
    </p>

    <button class="btn btn-success w-100 mt-3">نعم</button>
  </div>
</div>

<!-- Branch 3 -->
<div class="offcanvas offcanvas-start" id="branch3">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">معلومات الفرع الثالث</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <p>
      📍 الموقع: شارع الملك، وسط المدينة  
      📞 التواصل: +966 55 156 0015  
      🕒 ساعات العمل: 3:50 مساءً - 11:00 مساءً (السبت – الخميس)
    </p>

    <button class="btn btn-success w-100 mt-3">نعم</button>
  </div>
</div>

</body>
</html>


