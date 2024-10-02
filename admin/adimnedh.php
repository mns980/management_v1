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
    <title>إدارة الأصناف</title>
    <link rel="stylesheet" href="admined.css">
    <script src="./js/adminj.js"></script> <!-- ربط ملف الجافا سكريبت -->
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
            overflow-y: auto;
        }

        /* Navbar Styles */
        header {
            width: 100%;
            background-color: #00796b;
            padding: 10px 0;
            position: fixed;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-bottom: 3px solid #004d40;
        }

        nav ul {
            display: flex;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            display: block;
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.1s ease, box-shadow 0.1s ease;
            border-radius: 5px;
        }

        nav ul li a:hover {
            background-color: #004d40;
            color: #e0f2f1;
            transform: translateY(-0.5px);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        nav ul li a:active {
            background-color: #388e3c;
            transform: translateY(0);
        }

        /* Main content */
        main {
            margin-top: 100px; /* لعدم تغطية المحتوى بالقائمة الثابتة */
            text-align: center;
            width: 70%;
            max-width: 800px;
            padding: 0 20px;
        }

        h2, h3 {
            color: #00796b;
        }

        .section-container {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fff;
            border: 2px solid #00796b;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* New Add User Section Styles */
        .section-container-add-user {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #e8f5e9; /* Light green background */
            border: 2px solid #388e3c; /* Different green border */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-input {
            padding: 10px;
            font-size: 16px;
            margin: 10px 0;
            width: 220px;
            border: 1px solid #388e3c;
            border-radius: 5px;
        }

        .input {
            padding: 10px;
            font-size: 16px;
            margin: 10px 10px 10px 0; /* لجعل الحقول في نفس السطر */
            width: 220px;
            border: 1px solid #388e3c;
            border-radius: 5px;
        }

        .quantity-input {
            padding: 10px;
            font-size: 16px;
            margin: 10px 0;
            width: 100px;
            border: 1px solid #388e3c;
            border-radius: 5px;
        }

        .submit-button {
            padding: 10px 20px;
            background-color: #388e3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #2e7d32;
        }

        .success-message {
            color: green;
            display: none;
            margin-top: 15px;
        }

        .disabled-button {
            background-color: grey;
            cursor: not-allowed;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border: 1px solid #00796b;
            border-radius: 10px;
            text-align: center;
            width: 40%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .modal-content p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .modal .button {
            margin: 10px;
        }

        /* Users Table Styles */
        #usersTable {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        #usersTable th, #usersTable td {
            padding: 15px;
            text-align: center;
        }

        #usersTable th {
            background-color: #00796b;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        #usersTable tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #usersTable tr:hover {
            background-color: #e0f2f1;
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
        <h2>إدارة الأصناف</h2>

        <!-- Display Table of Items -->
        <table>
            <thead>
                <tr>
                    <th>اسم القطعة</th>
                    <th>الكمية</th>
                    <th>تاريخ الإضافة</th>
                </tr>
            </thead>
            <tbody id="partsTableBody">
                <tr>
                    <td>المعالج</td>
                    <td id="cpu-quantity">5</td>
                    <td id="cpu-date">2024-09-25</td> <!-- إضافة التاريخ -->
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR0</td>
                    <td id="ddr0-quantity">10</td>
                    <td id="ddr0-date">2024-09-25</td> <!-- إضافة التاريخ -->
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR1</td>
                    <td id="ddr1-quantity">10</td>
                    <td id="ddr1-date">2024-09-25</td> <!-- إضافة التاريخ -->
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR2</td>
                    <td id="ddr2-quantity">10</td>
                    <td id="ddr2-date">2024-09-25</td> <!-- إضافة التاريخ -->
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR3</td>
                    <td id="ddr3-quantity">10</td>
                    <td id="ddr3-date">2024-09-25</td> <!-- إضافة التاريخ -->
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR4</td>
                    <td id="ddr4-quantity">10</td>
                    <td id="ddr4-date">2024-09-25</td> <!-- إضافة التاريخ -->
                </tr>
                <tr>
                    <td>الذاكرة العشوائية DDR5</td>
                    <td id="ddr5-quantity">10</td>
                    <td id="ddr5-date">2024-09-25</td> <!-- إضافة التاريخ -->
                </tr>
                <tr>
                    <td>القرص الصلب (HDD)</td>
                    <td id="hdd-quantity">8</td>
                    <td id="hdd-date">2024-09-25</td> <!-- إضافة التاريخ -->
                </tr>
                <tr>
                    <td>بطاقة الرسومات</td>
                    <td id="gpu-quantity">4</td>
                    <td id="gpu-date">2024-09-25</td> <!-- إضافة التاريخ -->
                </tr>
                <tr>
                    <td>لوحة الأم</td>
                    <td id="motherboard-quantity">6</td>
                    <td id="motherboard-date">2024-09-25</td> <!-- إضافة التاريخ -->
                </tr>
            </tbody>
        </table>

        <!-- Remove Item Section -->
        <div class="section-container">
            <h3>حذف الأصناف</h3>
            <div>
                <label for="removeSelect">اختر الصنف الذي تريد حذفه:</label>
                <select id="removeSelect" class="select-input">
                    <!-- Dropdown options will be populated dynamically -->
                </select>
                <button class="button" onclick="confirmRemove()">حذف</button>
            </div>
        </div>

        <!-- Add Item Section -->
        <div class="section-container">
            <h3>إضافة الأصناف</h3>
            <div style="display: flex; align-items: center;">
                <label for="addItem">أدخل اسم الصنف:</label>
                <input type="text" id="addItem" class="input" placeholder="اسم الصنف">

                <label for="addQuantity">الكمية:</label>
                <input type="number" id="addQuantity" class="quantity-input" placeholder="الكمية">
            </div>
            <button class="button" onclick="confirmAdd()">إضافة</button>
        </div>

        <!-- Add User Section -->
        <div class="section-container-add-user">
            <h3>إضافة مستخدم</h3>
            <div>
                <label for="username">اسم المستخدم:</label>
                <input type="text" id="username" class="form-input" placeholder="اسم المستخدم">

                <label for="password">كلمة السر:</label>
                <input type="password" id="password" class="form-input" placeholder="كلمة السر">
                
                <button id="submitButton" class="submit-button disabled-button" disabled>إضافة</button>
                <p class="success-message" id="successMessage">تمت إضافة المستخدم بنجاح!</p>
            </div>
        </div>

        <!-- Users Table Section (New) -->
        <div class="section-container">
            <h3>المستخدمين المضافين</h3>
            <table id="usersTable">
                <thead>
                    <tr>
                        <th>اسم المستخدم</th>
                        <th>تاريخ الإضافة</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <!-- سيتم إضافة المستخدمين هنا ديناميكياً -->
                </tbody>
            </table>
        </div>

    </main>

    <!-- JavaScript -->
    <script src="./js/adminj.js"></script>
</body>
</html>
