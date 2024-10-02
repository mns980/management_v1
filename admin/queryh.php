<?php

require_once '../inc/connection.php';
session_start();

if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: ./auth/login.php");
    exit;
}
$query_mint = "select * from maintenance_request";
$result_mint = mysqli_query($conn, $query_mint);



$query_req = "select * from request_computer";
$result_req = mysqli_query($conn, $query_req);
?>




<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلبات الصيانة والحاسب الآلي</title>
    <link rel="stylesheet" href="../css/admin_styles/querycc.css">
    <style>
        /* تنسيقات عامة للجدول */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
            table-layout: auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            font-size: 16px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #00796b;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            border-bottom: 3px solid #004d40;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0f7fa;
            transition: background-color 0.3s ease;
        }

        /* تنسيقات لتحسين نموذج الاستعلام */
        form {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        label {
            font-size: 18px;
            color: #00796b;
            margin-right: 10px;
        }

        input[type="date"], select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #00796b;
            border-radius: 5px;
            margin: 10px 0;
        }

        button {
            padding: 10px 20px;
            background-color: #00796b;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #004d40;
        }

        /* إشعارات المستخدم */
        .alert {
            display: none;
            padding: 10px;
            margin-top: 15px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* جدول النتائج */
        #results {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar-container">
            <a href="./" class="navbar-link">الرئيسية</a>
            <a href="#" class="navbar-link">من نحن</a>
        </nav>
    </header>

    <main>
        <!-- نموذج الاستعلام حول الطلبات بناءً على التاريخ -->
        <h2>استعلام حول الطلبات</h2>
        <form id="query-form">
            <label for="start-date">اختر تاريخ البداية:</label>
            <input type="date" id="start-date" name="start-date" required>
            
            <label for="end-date">اختر تاريخ النهاية:</label>
            <input type="date" id="end-date" name="end-date" required>
            
            <label for="table-query">اختر الجدول للاستعلام:</label>
            <select id="table-query" name="table-query">
                <option value="maintenance">طلبات صيانة حاسب آلي</option>
                <option value="computer">طلبات حاسب آلي</option>
            </select>
            
            <button type="submit">استعلام</button>
        </form>

        <!-- إشعارات للمستخدم -->
        <div id="alert" class="alert"></div>

        <!-- جدول طلب صيانة حاسب آلي -->
        <h2>طلبات صيانة حاسب آلي</h2>
        <table>
            <thead>
                <tr>
                    <th>التاريخ</th>
                    <th>اسم الشخص / المدرسة / القسم</th>
                    <th>نوع الصيانة</th>
                    <th>نوع الجهاز</th>
                    <th>وصف دقيق للمشكلة</th>
                    <th>رقم الهاتف</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result_mint))
            {
                ?>
                <tr>
                    <td><?php echo $row['date'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['maintenance_type'] ?></td>
                    <td><?php echo $row['device_type'] ?></td>
                    <td><?php echo $row['description'] ?></td>
                    <td><?php echo $row['phone_number'] ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        </table>

        <!-- جدول طلب حاسب آلي -->
        <h2>طلبات حاسب آلي</h2>
        <table>
            <thead>
                <tr>
                    <th>التاريخ</th>
                    <th>اسم المدرسة / القسم / الإدارة</th>
                    <th>المرحلة</th>
                    <th>التصنيف</th>
                    <th>اسم المدير / المديرة</th>
                    <th>رقم جوال المدير/ة</th>
                    <th>نوع الجهاز المطلوب</th>
                    <th>استخدام الجهاز</th>
                    <th>سبب الاحتياج</th>
                    <th>عدد الأجهزة المكتبية الموجودة</th>
                    <th>هل يوجد أجهزة مكتبية تالفة</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($row_req = mysqli_fetch_assoc($result_req))
            {
                ?>
                <tr>
                    <td><?php echo $row_req['date'] ?></td>
                    <td><?php echo $row_req['school_name'] ?></td>
                    <td><?php echo $row_req['stage'] ?></td>
                    <td><?php echo $row_req['category'] ?></td>
                    <td><?php echo $row_req['manager_name'] ?></td>
                    <td><?php echo $row_req['phone_number'] ?></td>
                    <td><?php echo $row_req['required_device_type'] ?></td>
                    <td><?php echo $row_req['use_of_device'] ?></td>
                    <td><?php echo $row_req['reason_for_need'] ?></td>
                    <td><?php echo $row_req['desktop_device_count'] ?></td>
                    <td><?php echo $row_req['damaged_unused_equipment'] . $row_req['damaged_unused_equip_qty'] ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        </table>

        <!-- جدول النتائج بناءً على الاستعلام -->
        <div id="results">
            <h2>نتائج الاستعلام</h2>
            <table id="results-table">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>اسم المدرسة / القسم / الإدارة</th>
                        <th>المرحلة</th>
                        <th>التصنيف</th>
                        <th>اسم المدير / المديرة</th>
                        <th>رقم جوال المدير/ة</th>
                        <th>نوع الجهاز المطلوب</th>
                        <th>استخدام الجهاز</th>
                        <th>سبب الاحتياج</th>
                        <th>عدد الأجهزة المكتبية الموجودة</th>
                        <th>هل يوجد أجهزة مكتبية تالفة</th>
                    </tr>
                </thead>
                <tbody id="results-body">
                    <!-- سيتم تعبئة النتائج هنا -->
                </tbody>
            </table>
        </div>
    </main>

    <!--<script>
        // تفاعل الفورم باستخدام JavaScript
        document.getElementById('query-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            const tableQuery = document.getElementById('table-query').value;
            const alertBox = document.getElementById('alert');
            const resultsTable = document.getElementById('results');
            const resultsBody = document.getElementById('results-body');

            if (new Date(startDate) > new Date(endDate)) {
                alertBox.innerHTML = 'خطأ: تأكد من أن تاريخ النهاية أكبر من تاريخ البداية.';
                alertBox.className = 'alert alert-error';
                alertBox.style.display = 'block';
                resultsTable.style.display = 'none';
            } else {
                // إعادة تعيين إشعار المستخدم
                alertBox.style.display = 'none';

                // تنفيذ الاستعلام (محاكاة الاستعلام من خلال بيانات افتراضية)
                let data = [];
                if (tableQuery === 'computer') {
                    data = [
                        {date: '2024-09-22', name: 'مدرسة المعرفة', stage: 'ابتدائي', category: 'بنين', director: 'أ. خالد أحمد', phone: '0509876543', device: 'جهاز حاسب إلي', usage: 'الأعمال المكتبية', reason: 'توسيع المعامل', count: '5', damaged: 'نعم - 2 أجهزة تالفة'},
                        {date: '2024-09-18', name: 'قسم الشؤون الإدارية', stage: 'غير ذلك', category: 'بنات', director: 'أ. سارة محمد', phone: '0551234567', device: 'شاشة حاسب إلي', usage: 'للفصول الدراسية', reason: 'تحديث المعدات', count: '10', damaged: 'لا'}
                    ];
                } else if (tableQuery === 'maintenance') {
                    // إضافة بيانات افتراضية للصيانة إذا تم اختيار هذا الجدول
                    data = [
                        {date: '2024-09-25', name: 'مدرسة الأمل', stage: '-', category: '-', director: '-', phone: '0501234567', device: 'حاسب آلي', usage: 'برمجية', reason: 'توقف النظام', count: '-', damaged: '-'},
                        {date: '2024-09-20', name: 'قسم التقنية', stage: '-', category: '-', director: '-', phone: '0557654321', device: 'طابعة', usage: 'أجهزة', reason: 'الطابعة لا تعمل', count: '-', damaged: '-'}
                    ];
                }

                // تعبئة الجدول بالبيانات
                resultsBody.innerHTML = '';
                data.forEach(function(item) {
                    const row = `<tr>
                        <td>${item.date}</td>
                        <td>${item.name}</td>
                        <td>${item.stage}</td>
                        <td>${item.category}</td>
                        <td>${item.director}</td>
                        <td>${item.phone}</td>
                        <td>${item.device}</td>
                        <td>${item.usage}</td>
                        <td>${item.reason}</td>
                        <td>${item.count}</td>
                        <td>${item.damaged}</td>
                    </tr>`;
                    resultsBody.innerHTML += row;
                });

                // عرض النتائج
                resultsTable.style.display = 'block';
            }
        });
    </script>-->
</body>
</html>
