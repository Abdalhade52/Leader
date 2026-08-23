<html>

<head>




</head>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Success Page</title>

<style>
    body {
        background: #eef1f7;
        font-family: Tahoma, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card {
        width: 420px;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        text-align: center;
    }

    .card h2 {
        color: #0d6efd;
        margin-bottom: 10px;
    }

    .card p {
        color: #555;
        margin-bottom: 20px;
    }

    .btn,
    .btn2 {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.3s;
    }

    .btn2 {
        background: #198754;
        color: #fff;
    }

    .btn2:hover {
        background: #146c43;
    }

    .btn {
        background: #0d6efd;
        color: #fff;
    }

    .btn:hover {
        background: #0b5ed7;
    }
</style>
</head>

<body>

<div class="card">
    <h2>SUCCESSFUL!!</h2>
    <h5>Finish</h5>
    <p>The operation was successful</p>

    <form action="GEB2.php" method="get">
        <button type="submit" class="btn2">Goods exported to branches</button>
    </form>

    <form action="imported.php" method="post">
        <button type="submit" class="btn">Back</button>
        <button type="submit" class="btn">Add new goods</button>
    </form>
</div>

</body>
</html>






