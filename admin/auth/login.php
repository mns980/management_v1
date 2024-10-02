<?php
require_once '../../inc/connection.php';

session_start();

if (isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] === true) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row["password"];

        if (password_verify($password, $hashed_password)) {
            $_SESSION["admin_logged_in"] = true;
            $_SESSION["admin_name"] = $row["fullname"]; // Assuming the admin's name is stored in the "name" column
            header("Location: ../index.php");
            exit;
        } else {
            $error = "اسم المستخدم أو كلمة المرور غير صحيحين";
        }
    } else {
        $error = "اسم المستخدم أو كلمة المرور غير صحيحين";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة تسجيل الدخول</title>
    <link rel="stylesheet" href="../../css/admin_styles/regiss.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="login-box">
            <h2>تسجيل الدخول</h2>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <div class="input-box">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" id="username" name="username" placeholder="أدخل اسم المستخدم">
                </div>
                <div class="input-box">
                    <label for="password">كلمة المرور</label>
                    <input type="password" id="password" name="password" placeholder="أدخل كلمة المرور">
                </div>
                <button type="submit">تسجيل الدخول</button>
                <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
            </form>
        </div>
        <img src="../../images/cropimage.png" alt="صورة" class="top-right-logo">
    </div>

</body>
</html>