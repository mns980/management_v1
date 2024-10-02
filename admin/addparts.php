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
    <title>جدول اضافة كمية</title>
    <link rel="stylesheet" href="./css/addpartsc.css">
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
            transition: background-color 0.3s ease;
            overflow-y: auto;
        }

        /* Navbar Styles */
        header {
            width: 100%;
            background-color: #00796b;
            padding: 10px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        nav ul {
            display: flex;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin: 0 30px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #004d40;
            transform: scale(1.05);
        }

        main {
            margin-top: 100px;
            text-align: center;
            width: 70%;
            max-width: 800px;
            padding: 0 20px;
        }

        h2 {
            font-size: 24px;
            color: #00796b;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            max-width: 800px;
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

        .add-part-container {
            margin-top: 20px;
            border: 2px solid #00796b;
            border-radius: 10px;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .part-select, .quantity-input {
            padding: 10px;
            font-size: 16px;
            width: 220px;
            margin: 5px 10px;
            border: 1px solid #00796b;
            border-radius: 5px;
        }

        .add-part-button {
            padding: 10px 20px;
            background-color: #00796b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin: 10px 0;
        }

        .add-part-button:hover {
            background-color: #004d40;
            transform: scale(1.05);
        }

        footer {
            background-color: #00796b;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .footer-text {
            margin: 0;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
            }

            nav ul li {
                margin: 5px 0;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="admin.html">الرئيسية</a></li>
                <li><a href="whowere.html" class="nav-button">من نحن</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>جدول إضافة كمية</h2>
        <table>
            <thead>
                <tr>
                    <th>اسم القطعة</th>
                    <th>الكمية</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody id="partsTableBody">
                <tr>
                    <td>المعالج</td>
                    <td id="cpu-quantity">5</td>
                    <td>2024-09-25</td>
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR0</td>
                    <td id="ddr0-quantity">10</td>
                    <td>2024-09-25</td>
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR1</td>
                    <td id="ddr1-quantity">10</td>
                    <td>2024-09-25</td>
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR2</td>
                    <td id="ddr2-quantity">10</td>
                    <td>2024-09-25</td>
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR3</td>
                    <td id="ddr3-quantity">10</td>
                    <td>2024-09-25</td>
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR4</td>
                    <td id="ddr4-quantity">10</td>
                    <td>2024-09-25</td>
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR5</td>
                    <td id="ddr5-quantity">10</td>
                    <td>2024-09-25</td>
                </tr>
                <tr>
                    <td>القرص الصلب (HDD)</td>
                    <td id="hdd-quantity">8</td>
                    <td>2024-09-25</td>
                </tr>
                <tr>
                    <td>بطاقة الرسومات</td>
                    <td id="gpu-quantity">4</td>
                    <td>2024-09-25</td>
                </tr>
                <tr>
                    <td>لوحة الأم</td>
                    <td id="motherboard-quantity">6</td>
                    <td>2024-09-25</td>
                </tr>
                <tr>
                    <td>لوحة مفاتيح USB</td>
                    <td id="keyboard-quantity">12</td>
                    <td>2024-09-25</td>
                </tr>
                <tr>
                    <td>فأرة</td>
                    <td id="mouse-quantity">15</td>
                    <td>2024-09-25</td>
                </tr>
                <tr>
                    <td>فأرة USB</td>
                    <td id="usb-mouse-quantity">10</td>
                    <td>2024-09-25</td>
                </tr>
            </tbody>
        </table>

        <div class="add-part-container">
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

            <label for="addQuantity">الكمية المراد إضافتها:</label>
            <input type="number" class="quantity-input" id="addQuantity" placeholder="الكمية">
            <button class="add-part-button" onclick="addPart()">إضافة قطعة</button>
        </div>
    </main>

    <script>
        function addPart() {
            const partName = document.getElementById('partSelect').value;
            const addQuantity = parseInt(document.getElementById('addQuantity').value);
            const tableBody = document.getElementById('partsTableBody');
            const rows = tableBody.getElementsByTagName('tr');

            // الحصول على التاريخ الحالي
            const today = new Date();
            const date = today.toISOString().split('T')[0]; // الحصول على التاريخ بصيغة YYYY-MM-DD

            for (let i = 0; i < rows.length; i++) {
                const cell = rows[i].getElementsByTagName('td')[0]; // اسم القطعة
                const quantityCell = rows[i].getElementsByTagName('td')[1]; // الكمية
                const dateCell = rows[i].getElementsByTagName('td')[2]; // عمود التاريخ

                if (cell && cell.textContent === partName) {
                    const currentQuantity = parseInt(quantityCell.textContent);
                    const newQuantity = currentQuantity + addQuantity;

                    quantityCell.textContent = newQuantity; // تحديث الكمية
                    dateCell.textContent = date; // تحديث التاريخ
                    break;
                }
            }
        }
    </script>
</body>
</html>
