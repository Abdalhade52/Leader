<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Imported Goods Form</title>

<!-- Icons -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>
    body {
        background: linear-gradient(135deg, #dfe9f3, #eef1f7);
        font-family: Tahoma, sans-serif;
        display: flex;
        justify-content: center;
        padding-top: 40px;
    }

    .container {
        width: 100%;
        max-width: 650px;
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h2 {
        text-align: center;
        color: #0d6efd;
        font-size: 28px;
        margin-bottom: 10px;
        font-weight: bold;
    }

    p {
        text-align: center;
        color: #555;
        margin-bottom: 25px;
        font-size: 15px;
    }

    form {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
    }

    label {
        width: 100%;
        font-weight: bold;
        color: #333;
        font-size: 15px;
    }

    .input-box {
        position: relative;
        width: 100%;
    }

    .input-box input,
    .input-box select {
        width: 100%;
        padding: 12px 40px 12px 12px;
        border: 1px solid #ccc;
        border-radius: 10px;
        outline: none;
        transition: 0.3s;
        font-size: 15px;
    }

    .input-box input:focus,
    .input-box select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 5px rgba(13,110,253,0.3);
    }

    .input-box i {
        position: absolute;
        right: 12px;
        top: 12px;
        font-size: 20px;
        color: #777;
    }

    input[type=submit] {
        width: 100%;
        background: #0d6efd;
        color: #fff;
        padding: 14px;
        border: none;
        border-radius: 12px;
        font-size: 17px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: bold;
    }

    input[type=submit]:hover {
        background: #0b5ed7;
    }

    .btn-search {
        margin-top: 20px;
        width: 100%;
        background: #444;
        color: #fff;
        padding: 12px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        font-size: 16px;
    }

    .btn-search:hover {
        background: #222;
    }
</style>
</head>

<body>

<div class="container">
    <h2>Imported Goods Form</h2>
    <p>Data on imported goods</p>

    <form action="imported3.php" method="post">

        <label for="nameofimported">Name of Imported:</label>
        <div class="input-box">
            <input type="text" id="nameofimported" name="nameofimported" placeholder="Enter imported item name">
            <i class='bx bx-package'></i>
        </div>

        <label for="Quantity">Quantity:</label>
        <div class="input-box">
            <input type="number" id="Quantity" name="Quantity" placeholder="Enter quantity">
            <i class='bx bx-list-ol'></i>
        </div>

        <label for="import">Place of Import:</label>
        <div class="input-box">
            <select id="import" name="import">
                <option value="australia">Australia</option>
                <option value="canada">Canada</option>
                <option value="usa">USA</option>
            </select>
            <i class='bx bx-globe'></i>
        </div>

        <label for="Cost">Cost:</label>
        <div class="input-box">
            <input type="text" id="Cost" name="Cost" placeholder="Enter cost">
            <i class='bx bx-dollar'></i>
        </div>

        <label for="date">Import Date:</label>
        <div class="input-box">
            <input type="date" id="date" name="date">
            <i class='bx bx-calendar'></i>
        </div>

        <input type="submit" value="Submit">
    </form>

    <form action="branches.php" method="get">
        <button type="submit" class="btn-search">بحث عن الأفرع</button>
    </form>
</div>

</body>
</html>

