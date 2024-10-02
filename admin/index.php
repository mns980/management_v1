<?php
session_start();

if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: ./auth/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة المشرف</title>
    <link rel="stylesheet" href="../css/admin_styles/admin.css">
</head>
<body>
    <header>
        <nav class="navbar-container">
            <a href="../" class="navbar-link">الرئيسية</a>
            <a href="whowere.html" class="navbar-link">من نحن</a>
            <a href="./auth/logout.php" class="navbar-link">تسجيل خروج</a>
        </nav>
    </header>

    <img src="../images/cropimage.png" alt="شعار" class="logo"> <!-- شعار خارج الهيدر -->

    <main>
            <div class="welcome-message">
            <h2>مرحبًا بك أستاذ | <?php echo isset($_SESSION["admin_name"]) ? $_SESSION["admin_name"] : 'Unknown'; ?></h2>
            <p>يرجى اختيار أحد الخيارات من الأسفل لإدارة الموقع.</p>
        </div>

        <div class="button-container">
            <a href="./item.php" class="button-link">المخزون</a>
            <a href="removepart.php" class="button-link">صرف القطع</a>
            <a href="addparts.php" class="button-link">إضافة كمية</a>
            <a href="queryh.php" class="button-link">استعلام عن الطلبات</a> 
            <a href="queryh.php" class="button-link">طلبات الحاسب الآلي</a> 
            <a href="queryh.php" class="button-link">طلبات الصيانة</a> 
            <a href="adimnedh.php" class="button-link">صفحة التعديلات</a>
            <a href="./add_admin.php" class="button-link">إضافة مسؤول في النظام</a> 
        </div>

            
    </main>

</body>
</html>
