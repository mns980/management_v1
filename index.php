<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة تقنية المعلومات</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="navbar">
    <div class="navbar-container">
        <a href="./admin/" class="admin-link">الإدارة</a>
        <a href="https://wa.me/966534435949" class="navbar-link">تواصل معنا</a>
        <a href="./whowere.html" class="navbar-link">من نحن</a>
        <a href="./" class="navbar-link">الرئيسية</a>
    </div>
</header>



    <main>
        <section class="intro">
            <h1>إدارة تقنية المعلومات</h1>
            <p>مرحبا بك في موقعنا، هنا يمكنك طلب إعادة تدوير أو صيانة أجهزة الحاسب الآلي.</p>
            <p class="important-message">اختر العطل الذي تواجهه</p>
            <div class="button-container">
                <a href="./request_computer.php" class="btn explore-button">طلب حاسب آلي</a>
                <a href="./reqfixpc.php" class="btn recycle-button">صيانة الحاسب الالي</a>
                <a href="./request_return.php" class="btn recycle-button">طلب استرجاع</a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 جميع الحقوق محفوظة. إدارة تقنية المعلومات</p>
    </footer>

    <div class="back-to-top" id="back-to-top">
        <a href="#top">↑ العودة للأعلى</a>
    </div>

    <script>
        const backToTop = document.getElementById('back-to-top');
        window.onscroll = function() {
            if (window.scrollY > 200) {
                backToTop.style.display = 'block';
            } else {
                backToTop.style.display = 'none';
            }
        };
    </script>
</body>
</html>
