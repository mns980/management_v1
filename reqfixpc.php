<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب صيانة</title>
    <link rel="stylesheet" href="./css/reqfixp.css">
    <script src="./js/sweetalert2.js"></script>
</head>

<?php

// Include the connection file
include './inc/connection.php';

// Initialize variables to store user input
$name = '';
$maintenance_type = '';
$device_type = '';
$description = '';
$phone_number = '';

$errors = []; // Array to hold error messages
$send_data = false; // Flag to track if data is successfully sent

// Check if the form has been submitted
if (isset($_POST['submit'])) {

    // Store user input in variables
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $maintenance_type = htmlspecialchars($_POST['repair-type'], ENT_QUOTES, 'UTF-8');
    $device_type = htmlspecialchars($_POST['device-type'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $phone_number = htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8');

    // Validate user input
    if (empty($name)) {
        $errors[] = 'قم بكتابة اسمك او اسم الجهة';
    }
    if (empty($maintenance_type)) {
        $errors[] = 'قم بإختيار نوع الصيانة';
    }
    if (empty($device_type)) {
        $errors[] = 'قم بإختيار نوع الجهاز';
    }
    if (empty($description)) {
        $errors[] = 'قم بكتابة وصف للمشكلة';
    }
    if (empty($phone_number)) {
        $errors[] = 'قم بكتابة رقم الهاتف لتواصل معكم';
    }

    // Check if there are any errors
    if (empty($errors)) {
        // If no errors, proceed to insert data into the database
        $stmt = $conn->prepare("INSERT INTO maintenance_request(`name`, `maintenance_type`,`device_type`, `description`, `phone_number`) 
        VALUES(?,?,?,?,?)");
        $stmt->bind_param("sssss", $name, $maintenance_type, $device_type, $description, $phone_number);
        
        if ($stmt->execute()) {
            // If data is inserted successfully, display success message with SweetAlert
            $send_data = true;
        }
    }
}

?>

<body>

<?php if ($send_data): ?>
    <script>
        Swal.fire({
            position: "center", 
            icon: "success",
            title: "تم الارسال بنجاح",
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            // Clear the form inputs after success
            document.getElementById("name-input").value = "";
            document.getElementById("device-type").value = "";
            document.getElementById("problem-description").value = "";
            document.getElementById("phone-number").value = "";
            document.querySelector('input[name="repair-type"]:checked').checked = false;
        });
    </script>
<?php elseif (!empty($errors)): ?>
    <script>
        Swal.fire({
            position: "center",
            icon: "error",
            title: "<?php echo implode('<br>', $errors); ?>",
            showConfirmButton: true,
            confirmButtonText: "حسناً"
        });
    </script>
<?php endif; ?>

    <header class="navbar">
        <div class="navbar-container">
            <a href="./" class="navbar-link home-link">الرئيسية</a>
            <a href="#about" class="navbar-link center-link">من نحن</a>
            <a href="https://wa.me/966534435949" class="navbar-link contact-link">تواصل معنا</a>
        </div>
    </header>

    <form method="POST">
        <main>
            <section class="intro">
                <h1>طلب صيانة</h1>

                <!-- Question 1 -->
                <div class="question-container">
                    <div class="question-number">1</div>
                    <div class="question-text">
                        <label for="name-input" class="question-label">اسم الشخص \ المدرسة \ القسم</label>
                        <input type="text" id="name-input" name="name" value="<?php echo $name; ?>" placeholder="ادخل اجابتك" class="answer-input" required>
                    </div>
                </div>

                <!-- Question 2 -->
                <div class="question-container">
                    <div class="question-number">2</div>
                    <div class="question-text">
                        <label class="question-label">نوع الصيانة</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" id="computer-repair" name="repair-type" value="جهاز حاسب آلي" <?php if ($maintenance_type == 'جهاز حاسب آلي') echo 'checked'; ?>>
                                <label for="computer-repair">جهاز حاسب آلي</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="data-show-repair" name="repair-type" value="data show" <?php if ($maintenance_type == 'data show') echo 'checked'; ?>>
                                <label for="data-show-repair">data show</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="printer-repair" name="repair-type" value="طابعة" <?php if ($maintenance_type == 'طابعة') echo 'checked'; ?>>
                                <label for="printer-repair">طابعة</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question 3 -->
                <div class="question-container">
                    <div class="question-number">3</div>
                    <div class="question-text">
                        <label for="device-type" class="question-label">نوع الجهاز</label>
                        <input type="text" id="device-type" name="device-type" value="<?php echo $device_type; ?>" placeholder="ادخل اجابتك" class="answer-input" required>
                    </div>
                </div>

                <!-- Question 4 -->
                <div class="question-container">
                    <div class="question-number">4</div>
                    <div class="question-text">
                        <label for="problem-description" class="question-label">وصف دقيق للمشكلة</label>
                        <textarea id="problem-description" name="description" placeholder="ادخل اجابتك" class="answer-input large-textarea" required><?php echo $description; ?></textarea>
                    </div>
                </div>

                <!-- Question 5 -->
                <div class="question-container">
                    <div class="question-number">5</div>
                    <div class="question-text">
                        <label for="phone-number" class="question-label">رقم الهاتف</label>
                        <input type="tel" id="phone-number" name="phone" value="<?php echo $phone_number; ?>" placeholder="ادخل اجابتك" pattern="[0-9]*" inputmode="numeric" class="answer-input text-right" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="submit-container">
                    <button type="submit" name="submit" class="submit-button">إرسال</button>
                    <p class="note">يتم إرسال البيانات التي ترسلها إلى مالك الموقع.</p>
                </div>
            </section>
        </main>
    </form>

</body>
</html>
