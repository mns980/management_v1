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
  <title>إدارة المسؤولين</title>
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
            margin-bottom: 20px;
            padding: 20px;
            background-color: #e8f5e9; /* Light green background */
            border: 2px solid #388e3c; /* Different green border */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .section-container-add-user div {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .section-container-add-user label {
            margin-bottom: 5px;
        }

        .section-container-add-user input {
            margin-bottom: 5px;
        }

        .section-container-add-user button {
            margin-top: 10px;
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

<script src="../js/sweetalert2.js"></script>
</head>
<body>

<header>
  <nav>
    <ul>
      <li><a href="./" class="nav-button">الرئيسية</a></li>
      <li><a href="whowere.html" class="nav-button">من نحن</a></li>
    </ul>
  </nav>
</header>
<?php
require_once '../inc/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = filter_var($_POST["fullname"], FILTER_SANITIZE_STRING);
  $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
  $phonenumber = filter_var($_POST["phonenumber"], FILTER_SANITIZE_STRING);
  $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  if (empty($fullname) || empty($username) || empty($email) || empty($phonenumber) || empty($password)) {
    echo '<script>
      Swal.fire({
        icon: "error",
        title: "خطأ",
        text: "يرجى ملء جميع الحقول",
        confirmButtonText: "حسناً",
      });
    </script>';
  } elseif ($email === false) {
    echo '<script>
      Swal.fire({
        icon: "error",
        title: "خطأ",
        text: "البريد الالكتروني غير صحيح",
        confirmButtonText: "حسناً",
      });
    </script>';
  } else {
    $currentTime = date('Y-m-d H:i:s');
    $sql = "INSERT INTO admin (fullname, username, email, phone_number, password, date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $fullname, $username, $email, $phonenumber, $hashed_password, $currentTime);
    $stmt->execute();

    echo '<script>
      Swal.fire({
        icon: "success",
        title: "تمت الإضافة بنجاح",
        text: "تمت إضافة المستخدم بنجاح",
      });
    </script>';
  }
}

?>
<main>
  <h2>إدارة المسؤولين</h2>
  <!-- Add User Section -->
  <form action="" method="post">
    <div class="section-container-add-user">
      <h3>إضافة مستخدم</h3>
      <div>
        <label for="fullname">الاسم :</label>
        <input type="text" id="fullname" class="form-input" placeholder="الاسم" name="fullname">
        
        <label for="username">اسم المستخدم:</label>
        <input type="text" id="username" class="form-input" placeholder="اسم المستخدم" name="username">

        <label for="email">البريد الالكتروني :</label>
        <input type="email" id="email" class="form-input" placeholder="البريد الالكتروني" name="email">

        <label for="phonenumber">رقم الهاتف :</label>
        <input type="text" id="phonenumber" class="form-input" placeholder="رقم الهاتف" name="phonenumber">

        <label for="password">كلمة السر:</label>
        <input type="password" id="password" class="form-input" placeholder="كلمة السر" name="password">
        
        <button id="submitButton" class="submit-button" type="submit">إضافة</button>
        <p class="success-message" id="successMessage">تمت إضافة المستخدم بنجاح!</p>
      </div>
    </div>
  </form>

  <!-- Users Table Section (New) -->
  <div class="section-container">
    <h3>المستخدمين المضافين</h3>
    <table id="usersTable">
      <thead>
        <tr>
          <th>#</th>
          <th>الاسم</th>
          <th>اسم المستخدم</th>
          <th>البريد الالكتروني</th>
          <th>رقم الهاتف</th>
          <th>تاريخ الإضافة</th>
        </tr>
      </thead>
      <tbody id="usersTableBody">
        <?php 
        $sql = "SELECT * FROM admin";
        $result = $conn->query($sql);
        $admins = array();
        while ($row = $result->fetch_assoc()) {
          $admins[] = $row;
        }


        foreach ($admins as $admin) {     
            ?>
        <tr>
          <td><?php echo $admin["id"]; ?></td>
          <td><?php echo $admin["fullname"]; ?></td>
          <td><?php echo $admin["username"]; ?></td>
          <td><?php echo $admin["email"]; ?></td>
          <td><?php echo $admin["phone_number"]; ?></td>
          <td><?php echo $admin["date"]; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</main>
</body>
</html>