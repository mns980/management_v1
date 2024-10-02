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
    <title>حذف قطع</title>
    <link rel="stylesheet" href="../css/admin_styles/removepartc.css">
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            margin: 0;
            background-color: #f0f4f3;
            overflow-y: auto; /* السماح بالتمرير */
        }

        /* Navbar Styles */
        header {
            width: 100%;
            background-color: #00796b;
            padding: 10px 0;
            display: flex;
            justify-content: center; /* لتوسيع الأزرار في المنتصف */
            align-items: center;
        }

        nav ul {
            display: flex;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin: 0 20px; /* زيادة المسافة بين الأزرار */
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 15px; /* زيادة المساحة حول النص */
            transition: background-color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #004d40; /* تأثير عند التحويم */
            border-radius: 5px; /* جعل الزر مستدير الحواف */
        }

        main {
            margin-top: 20px; /* تعديل المسافة العلوية */
            text-align: center;
            width: 90%; /* جعل عرض الصفحة مرن */
            max-width: 1000px; /* تحديد أقصى عرض */
            padding: 0 20px;
        }

        h2 {
            font-size: 24px;
            color: #00796b;
            margin-bottom: 20px;
        }

        /* تعديل على الجدول ليصبح مستجيب */
        .table-container {
            overflow-x: auto; /* إضافة تمرير أفقي إذا تجاوز الجدول العرض */
        }

        table {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            word-wrap: break-word; /* منع تجاوز النص لحدود الخلية */
        }

        th {
            background-color: #00796b;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0f2f1;
        }

        .remove-part-container {
            margin-top: 20px;
            border: 2px solid #00796b;
            border-radius: 10px;
            padding: 30px; /* زيادة المساحة الداخلية */
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .part-select, .quantity-input {
            padding: 10px;
            font-size: 16px;
            width: 220px; /* تعديل العرض للقائمة المنسدلة */
            margin: 5px 10px; /* إضافة هوامش */
            border: 1px solid #00796b;
            border-radius: 5px;
        }

        .remove-part-button {
            padding: 15px 30px; /* زيادة حجم الزر */
            background-color: #d32f2f; /* لون حذر */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px; /* مسافة فوق الزر */
            display: inline-block; /* لجعل الزر بحجم مناسب */
        }

        .remove-part-button:hover {
            background-color: #b71c1c; /* لون داكن عند التحويم */
        }

        footer {
            background-color: #00796b;
            color: white;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            bottom: 0;
        }

        .footer-text {
            margin: 0;
            font-size: 14px;
        }

        /* استجابة أفضل للشاشات الصغيرة */
        @media (max-width: 768px) {
            main {
                width: 100%; /* عرض الصفحة بالكامل على الشاشات الصغيرة */
            }

            th, td {
                padding: 10px; /* تقليل المسافات */
            }

            .remove-part-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="admin.html" class="nav-button">الرئيسية</a></li>
                <li><a href="whowere.html" class="nav-button">من نحن</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>جدول حذف الكمية</h2>

        <!-- إضافة تمرير إذا تجاوز الجدول العرض المتاح -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>اسم القطعة</th>
                        <th>الكمية</th>
                        <th>تاريخ الإضافة</th> <!-- عمود لتاريخ الإضافة -->
                    </tr>
                </thead>
                <tbody id="partsTableBody">
                    <tr>
                        <td>المعالج</td>
                        <td id="cpu-quantity">5</td>
                        <td class="part-date"></td>
                    </tr>
                    <tr>
                        <td>الذاكرة العشوائية DDR0</td>
                        <td id="ddr0-quantity">10</td>
                        <td class="part-date"></td>
                    </tr>
                    <tr>
                        <td>الذاكرة العشوائية DDR1</td>
                        <td id="ddr1-quantity">10</td>
                        <td class="part-date"></td>
                    </tr>
                    <tr>
                        <td>الذاكرة العشوائية DDR2</td>
                        <td id="ddr2-quantity">10</td>
                        <td class="part-date"></td>
                    </tr>
                    <tr>
                        <td>الذاكرة العشوائية DDR3</td>
                        <td id="ddr3-quantity">10</td>
                        <td class="part-date"></td>
                    </tr>
                    <tr>
                        <td>الذاكرة العشوائية DDR4</td>
                        <td id="ddr4-quantity">10</td>
                        <td class="part-date"></td>
                    </tr>
                    <tr>
                        <td>الذاكرة العشوائية DDR5</td>
                        <td id="ddr5-quantity">10</td>
                        <td class="part-date"></td>
                    </tr>
                    <tr>
                        <td>القرص الصلب (HDD)</td>
                        <td id="hdd-quantity">8</td>
                        <td class="part-date"></td>
                    </tr>
                    <tr>
                        <td>بطاقة الرسومات</td>
                        <td id="gpu-quantity">4</td>
                        <td class="part-date"></td>
                    </tr>
                    <tr>
                        <td>لوحة الأم</td>
                        <td id="motherboard-quantity">6</td>
                        <td class="part-date"></td>
                    </tr>
                    <tr>
                        <td>لوحة مفاتيح USB</td>
                        <td id="keyboard-quantity">12</td>
                        <td class="part-date"></td>
                    </tr>
                    <tr>
                        <td>فأرة</td>
                        <td id="mouse-quantity">15</td>
                        <td class="part-date"></td>
                    </tr>
                    <tr>
                        <td>فأرة USB</td>
                        <td id="usb-mouse-quantity">10</td>
                        <td class="part-date"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="remove-part-container">
            <label for="partSelect">اختر نوع القطعة:</label>
            <select id="partSelect" class="part-select">
                <option value="">-- اختر نوع القطعة --</option>
                <option value="المعالج">المعالج</option>
                <option value="الذاكرة العشوائية DDR0">الذاكرة العشوائية DDR0</option>
                <option value="الذاكرة العشوائية DDR1">الذاكرة العشوائية DDR1</option>
                <option value="الذاكرة العشوائية DDR2">الذاكرة العشوائية DDR2</option>
                <option value="الذاكرة العشوائية DDR3">الذاكرة العشوائية DDR3</option>
                <option value="الذاكرة العشوائية DDR4">الذاكرة العشوائية DDR4</option>
                <option value="الذاكرة العشوائية DDR5">الذاكرة العشوائية DDR5</option>
                <option value="القرص الصلب (HDD)">القرص الصلب (HDD)</option>
                <option value="بطاقة الرسومات">بطاقة الرسومات</option>
                <option value="لوحة الأم">لوحة الأم</option>
                <option value="لوحة مفاتيح USB">لوحة مفاتيح USB</option>
                <option value="فأرة">فأرة</option>
                <option value="فأرة USB">فأرة USB</option>
            </select>

            <label for="removeQuantity">الكمية المراد حذفها:</label>
            <input type="number" class="quantity-input" id="removeQuantity" placeholder="الكمية">
            <button class="remove-part-button" onclick="removePart()">حذف قطعة</button>
        </div>
    </main>
    
    <script>
        function getRandomDate(start, end) {
            const date = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
            return date.toISOString().split('T')[0]; // إرجاع التاريخ بتنسيق YYYY-MM-DD
        }

        function populateDates() {
            const dateCells = document.querySelectorAll('.part-date');
            const startDate = new Date(2023, 0, 1); // بداية التواريخ
            const endDate = new Date(); // التاريخ الحالي

            dateCells.forEach(cell => {
                cell.textContent = getRandomDate(startDate, endDate);
            });
        }

        function removePart() {
            const partName = document.getElementById('partSelect').value;
            const removeQuantity = parseInt(document.getElementById('removeQuantity').value);
            const tableBody = document.getElementById('partsTableBody');
            const rows = tableBody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const cell = rows[i].getElementsByTagName('td')[0]; // اسم القطعة
                const quantityCell = rows[i].getElementsByTagName('td')[1]; // الكمية

                if (cell && cell.textContent === partName) {
                    const currentQuantity = parseInt(quantityCell.textContent);
                    const newQuantity = currentQuantity - removeQuantity;

                    if (newQuantity < 0) {
                        alert('الكمية المدخلة أكبر من المتاحة!');
                    } else {
                        quantityCell.textContent = newQuantity; // تحديث الكمية
                    }
                    break;
                }
            }
        }

        // توليد التواريخ العشوائية عند تحميل الصفحة
        window.onload = populateDates;
    </script>
</body>
</html>
