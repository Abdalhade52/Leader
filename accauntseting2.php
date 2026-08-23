<form  method="post" action="accauntseting.php">
    <h2> تحديث معلومات الحساب</h2>
        <lable> البريد الالكتروني الجديد</lable>
<input type="email"   id="email"   name="email" required >
<label> كلمة المرور الجديدة</label>
<input type="password"  id="password" name="password" required>
<button type="submit"> حفظ التغيرات</button>
</form>

<style>
form {
    width: 300px;
    margin: 40px auto;
    padding: 20px;
    background: #f3f3f3;
    border-radius: 10px;
    font-family: Arial;
}
input, button {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
}
button {
    background: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}
button:hover {
    background: #0056b3;
}
</style>



