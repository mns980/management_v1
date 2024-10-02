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
    <title>جدول صرف القطع والكمية</title>
    <link rel="stylesheet" href="../css/admin_styles/checkpartsc.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="admin.html">الرئيسية</a></li>
                <li><a href="whowere.html" class="nav-button">من نحن</a></li>
            </ul>
        </nav>
        <img src="../images/cropimage.png" alt="شعار" class="logo">
    </header>

    <<main>
        <h2>جدول الرصيد</h2>
        <table>
            <thead>
                <tr>
                    <th>اسم القطعة</th>
                    <th>الكمية</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>المعالج</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR0</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR1</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR2</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR3</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR4</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR5</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>القرص الصلب (HDD)</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>بطاقة الرسومات</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>لوحة الأم</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>لوحة مفاتيح USB</td>
                    <td>12</td>
                </tr>
                <tr>
                    <td>فأرة</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>فأرة USB</td>
                    <td>10</td>
                </tr>
            </tbody>
        </table>
    </main>
</body>
</html>
