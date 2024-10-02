<?php 
// Include the connection file
include './inc/connection.php';

// Initialize variables to store user input
$school_name = '';
$category = '';
$manager_name = '';
$phone_number = '';
$required_device_type = '';
$use_of_device = '';
$reason_for_need = '';
$desktop_device_count = '';
$damaged_unused_equipment = '';
$stage = '';
$damaged_unused_equip_qty = '';

$errors = []; // Array to hold error messages
$send_data = false; // Flag to track if data is successfully sent

if(isset($_POST['submit'])){

    // Validate user input
    $school_name = htmlspecialchars($_POST['school-name'], ENT_QUOTES, 'UTF-8');
    $category = htmlspecialchars($_POST['category'], ENT_QUOTES, 'UTF-8');
    $manager_name = htmlspecialchars($_POST['manager_name'], ENT_QUOTES, 'UTF-8');
    $phone_number = htmlspecialchars($_POST['phone_number'], ENT_QUOTES, 'UTF-8');

    if (isset($_POST['device'])) {
        $required_device_type = htmlspecialchars($_POST['device'], ENT_QUOTES, 'UTF-8');
    }

    if (isset($_POST['usage'])) {
        $use_of_device = htmlspecialchars($_POST['usage'], ENT_QUOTES, 'UTF-8');
    }

    $reason_for_need = htmlspecialchars($_POST['reason_for_need'], ENT_QUOTES, 'UTF-8');
    $desktop_device_count = htmlspecialchars($_POST['device_qty'], ENT_QUOTES, 'UTF-8');

    if (isset($_POST['damaged'])) {
        $damaged_unused_equipment = htmlspecialchars($_POST['damaged'], ENT_QUOTES, 'UTF-8');
    }

    if (isset($_POST['other_stage']) && !empty($_POST['other_stage'])) {
        $stage = htmlspecialchars($_POST['other_stage'], ENT_QUOTES, 'UTF-8');
    } else {
        if (isset($_POST['stage']) && !empty($_POST['stage'])) {
            $stage = htmlspecialchars($_POST['stage'], ENT_QUOTES, 'UTF-8');
        } else {
            $errors[] = 'قم بإختيار المرحلة الدراسية'; // Trigger the warning if no stage is selected
        }
    }

    if (isset($_POST['damaged'])) {
        if ($_POST['damaged'] == 'لا') {
            $damaged_unused_equip_qty = 0; // Automatically set 0 when 'لا' is chosen
        } else {
            $damaged_unused_equip_qty = htmlspecialchars($_POST['damaged-count'], ENT_QUOTES, 'UTF-8');
            if (empty($damaged_unused_equip_qty)) {
                $errors[] = 'قم بكتابة عدد الأجهزة المكتبية التالفة أو غير المستخدمة';
            }
        }
    }

    // Validation
    if (empty($school_name)) {
        $errors[] = 'قم بكتابة اسم المدرسة/القسم/المكتب/الإدارة';
    }
    if (empty($category)) {
        $errors[] = 'قم بإختيار التصنيف بنين / بنات';
    }
    if (empty($manager_name)) {
        $errors[] = 'قم بكتابة اسم المدير/ة';
    }
    if (empty($phone_number)) {
        $errors[] = 'قم بكتابة رقم الهاتف لتواصل معكم';
    }
    if (empty($required_device_type)) {
        $errors[] = 'قم بإختيار نوع الجهاز المطلوب';
    }
    if (empty($use_of_device)) {
        $errors[] = 'قم بإختيار الغرض من استخدام الجهاز';
    }
    if (empty($reason_for_need)) {
        $errors[] = 'قم بكتابة سبب الاحتياج';
    }
    if (empty($desktop_device_count)) {
        $errors[] = 'قم بكتابة عدد الأجهزة المكتبية';
    }
    if (empty($damaged_unused_equipment)) {
        $errors[] = 'قم بإختيار هل يوجد أجهزة مكتبية تالفة أو غير مستخدمة';
    }

    if (empty($errors)) {
        // If no errors, proceed to insert data into the database
        $stmt = $conn->prepare("INSERT INTO request_computer(`school_name`, `stage`,`category`, `manager_name`, `phone_number`, `required_device_type`, `use_of_device`, `reason_for_need`, `desktop_device_count`, `damaged_unused_equipment`, `damaged_unused_equip_qty`) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssssssss", $school_name, $stage, $category, $manager_name, $phone_number, $required_device_type, $use_of_device, $reason_for_need, $desktop_device_count, $damaged_unused_equipment, $damaged_unused_equip_qty);
        if ($stmt->execute()) {
            // If data is inserted successfully, display success message with SweetAlert
            $send_data = true;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FixPc</title>
    <link rel="stylesheet" href="./css/req_comp.css">
    <script src="js/sweetalert2.js"></script>
</head>
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
            document.getElementById("school-input").value = "";
            document.getElementById("director-name").value = "";
            document.getElementById("director-phone").value = "";
            document.getElementById("need-reason").value = "";
            document.getElementById("computer-count").value = "";
            document.querySelector('input[name="category"]:checked').checked = false;
            document.querySelector('input[name="stage"]:checked').checked = false;
            document.querySelector('input[name="device"]:checked').checked = false;
            document.querySelector('input[name="usage"]:checked').checked = false;
            document.querySelector('input[name="damaged"]:checked').checked = false;
            document.getElementById("damaged-count").value = "";
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

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FixPc</title>
    <link rel="stylesheet" href="./css/req_comp.css">
    <script src="js/sweetalert2.js"></script>
</head>

<body>
    <header class="navbar">
        <div class="navbar-container">
            <a href="./" class="navbar-link home-link">الرئيسية</a>
            <a href="#about" class="navbar-link center-link">من نحن</a>
            <a href="https://wa.me/966534435949" class="navbar-link contact-link">تواصل معنا</a>
        </div>
    </header>
    <form method="POST" action="request_computer.php">
    <main>
        <section class="intro">
            <h1>طلب جهاز حاسب آلي</h1>

            <!-- Question 1 -->
            <div class="question-container">
                <div class="question-number">1</div>
                <div class="question-text">
                    <label for="school-input" class="question-label">اسم المدرسة / القسم / المكتب / الإدارة</label>
                    <input type="text" name="school-name" value="<?php echo $school_name; ?>" id="school-input" placeholder="أدخل إجابتك" class="answer-input">
                </div>
            </div>

            <!-- Question 2 -->
            <div class="question-container">
                <div class="question-number">2</div>
                <div class="question-text">
                    <label class="question-label">اختر المرحلة</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="primary" name="stage" value="ابتدائي" <?php if ($stage == 'ابتدائي') echo 'checked'; ?>>
                            <label for="primary">إبتدائي</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="intermediate" name="stage" value="متوسط" <?php if ($stage == 'متوسط') echo 'checked'; ?>> 
                            <label for="intermediate">متوسط</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="secondary" name="stage" value="ثانوي" <?php if ($stage == 'ثانوي') echo 'checked'; ?>>
                            <label for="secondary">ثانوي</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="early-childhood" name="stage" value="طفولة مبكرة" <?php if ($stage == 'طفولة مبكرة') echo 'checked'; ?>>
                            <label for="early-childhood">طفولة مبكرة</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="preschool" name="stage" value="رياض الاطفال" <?php if ($stage == 'رياض الاطفال') echo 'checked'; ?>> 
                            <label for="preschool">رياض الاطفال</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="other" name="stage" value="غير ذلك" <?php if ($stage == 'غير ذلك') echo 'checked'; ?>>
                            <label for="other">غير ذلك</label>
                        </div>
                    </div>
                    <div id="other-stage-container" class="hidden">
                        <label for="other-stage-input" class="question-label">يرجى تحديد المرحلة</label>
                        <input type="text" name="other_stage" id="other-stage-input" placeholder="أدخل إجابتك" class="answer-input">
                    </div>
                </div>
            </div>

            <!-- Question 3 -->
            <div class="question-container">
                <div class="question-number">3</div>
                <div class="question-text">
                    <label class="question-label">التصنيف</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="boys" name="category" value="بنين" <?php if ($category == 'بنين') echo 'checked'; ?>>
                            <label for="boys">بنين</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="girls" name="category" value="بنات" <?php if ($category == 'بنات') echo 'checked'; ?>>
                            <label for="girls">بنات</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question 4 -->
            <div class="question-container">
                <div class="question-number">4</div>
                <div class="question-text">
                    <label for="director-name" class="question-label">اسم المدير/ة</label>
                    <input type="text" name="manager_name" value="<?php echo $manager_name; ?>" id="director-name" placeholder="أدخل إجابتك" class="answer-input">
                </div>
            </div>

            <!-- Question 5 (Updated for Right Text Alignment) -->
            <div class="question-container">
                <div class="question-number">5</div>
                <div class="question-text">
                    <label for="director-phone" class="question-label">رقم جوال المدير/ة</label>
                    <input type="tel" name="phone_number" value="<?php echo $phone_number; ?>" id="director-phone" placeholder="أدخل رقم الجوال" pattern="[0-9]*" inputmode="numeric" class="answer-input text-right">
                </div>
            </div>

            <!-- Question 6 -->
            <div class="question-container">
                <div class="question-number">6</div>
                <div class="question-text">
                    <label class="question-label">نوع الجهاز المطلوب</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="full-computer" name="device" value="جهاز حاسب آلي كامل" <?php if ($required_device_type == 'جهاز حاسب آلي كامل') echo 'checked'; ?>>
                            <label for="full-computer">جهاز حاسب آلي كامل</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="computer-box" name="device" value="صندوق حاسب آلي فقط" <?php if ($required_device_type == 'صندوق حاسب آلي فقط') echo 'checked'; ?>>
                            <label for="computer-box">صندوق حاسب آلي فقط</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="computer-screen" name="device" value="شاشة حاسب آلي" <?php if ($required_device_type == 'شاشة حاسب آلي') echo 'checked'; ?>>
                            <label for="computer-screen">شاشة حاسب آلي</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question 7 -->
            <div class="question-container">
                <div class="question-number">7</div>
                <div class="question-text">
                    <label class="question-label">استخدام الجهاز</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="office-work" name="usage" value="للأعمال المكتبية" <?php if ($use_of_device == 'للأعمال المكتبية') echo 'checked'; ?>>
                            <label for="office-work">للأعمال المكتبية</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="classroom" name="usage" value="للفصول الدراسية" <?php if ($use_of_device == 'للفصول الدراسية') echo 'checked'; ?>>
                            <label for="classroom">للفصول الدراسية</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="laboratories" name="usage" value="المعامل المدرسية" <?php if ($use_of_device == 'المعامل المدرسية') echo 'checked'; ?>>
                            <label for="laboratories">المعامل المدرسية</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question 8 -->
            <div class="question-container">
                <div class="question-number">8</div>
                <div class="question-text">
                    <label for="need-reason" class="question-label">سبب الاحتياج</label>
                    <textarea id="need-reason" name="reason_for_need" placeholder="ادخل اجابتك" class="answer-input large-textarea"><?php echo $reason_for_need; ?></textarea>
                </div>
            </div>

            <!-- Question 9 -->
            <div class="question-container">
                <div class="question-number">9</div>
                <div class="question-text">
                    <label for="computer-count" class="question-label">عدد الأجهزة المكتبية الموجودة</label>
                    <input type="number" name="device_qty" value="<?php echo $desktop_device_count; ?>" id="computer-count" placeholder="الرجاء ادخال الرقم" class="answer-input" min="0">
                </div>
            </div>

<!-- Question 10 (Modified to include damaged count input) -->
<div class="question-container">
    <div class="question-number">10</div>
    <div class="question-text">
        <label class="question-label">هل يوجد أجهزة مكتبية تالفة أو غير مستخدمة؟</label>
        <div class="radio-group">
            <div class="radio-item">
                <input type="radio" id="damaged-yes" name="damaged" value="نعم" <?php if ($damaged_unused_equipment == 'نعم') echo 'checked'; ?>>
                <label for="damaged-yes">نعم</label>
            </div>
            <div class="radio-item">
                <input type="radio" id="damaged-no" name="damaged" value="لا" <?php if ($damaged_unused_equipment == 'لا') echo 'checked'; ?>>
                <label for="damaged-no">لا</label>
            </div>
        </div>

        <!-- Input field for number of damaged devices -->
        <div id="damaged-count-container" class="hidden">
            <label for="damaged-count" class="question-label">عدد الأجهزة المكتبية التالفة أو غير المستخدمة</label>
            <input type="number" name="damaged-count" value="<?php echo $damaged_unused_equip_qty; ?>" id="damaged-count" placeholder="الرجاء إدخال الرقم" class="answer-input" min="0">
        </div>
    </div>
</div>

<script>
// Show/hide the damaged count input based on the answer to question 10
const damagedYesRadio = document.getElementById('damaged-yes');
const damagedNoRadio = document.getElementById('damaged-no');
const damagedCountContainer = document.getElementById('damaged-count-container');
const damagedCountInput = document.getElementById('damaged-count');

damagedYesRadio.addEventListener('change', function() {
    damagedCountContainer.classList.remove('hidden'); // Show the input when "Yes" is selected
    damagedCountInput.required = true; // Make the input required when shown
});

damagedNoRadio.addEventListener('change', function() {
    damagedCountContainer.classList.add('hidden'); // Hide the input when "No" is selected
    damagedCountInput.required = false; // Make the input not required when hidden
    damagedCountInput.value = 0; // Set the input value to 0 when hidden
});
</script>


            <!-- Question 12 (Modified for interactivity) -->
            <div class="question-container">
                <div class="question-number question-12-number">11</div>
                <div class="question-text question-12-text">
                    <p><strong>في حال توفر الاجهزه المطلوبة وبعد الاتصال على رقم الجوال المسجل اعلاه يتم تعبئة نموذج نقل العهده 👇وإرساله مع المندوب عند الاستلام</strong></p>
                    <div class="file-preview-container">
                        <a href="work2.pdf" download class="pdf-link">تحميل PDF</a>
                        <img src="./images/work22.PNG" alt="PDF Preview" class="file-preview-image" onclick="showImage()">
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
    <script>
        // Interactivity for Question 2 (Show/Hide "غير ذلك" input field)
        const stageRadioButtons = document.querySelectorAll('input[name="stage"]');
        const otherStageContainer = document.getElementById('other-stage-container');
        const otherStageInput = document.getElementById('other-stage-input');

        stageRadioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'غير ذلك') {
                    otherStageContainer.classList.remove('hidden');
                    otherStageInput.required = true;
                } else {
                    otherStageContainer.classList.add('hidden');
                    otherStageInput.required = false;
                    otherStageInput.value = '';
                }
            });
        });

        // Show PDF Preview
        function showImage() {
            const img = document.querySelector('.file-preview-image');
            const newWindow = window.open("");
            newWindow.document.write(`<img src="${img.src}" style="width:100%; height:auto;">`);
        }
    </script>
</body>
</html>


