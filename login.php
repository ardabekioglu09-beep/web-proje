<?php
// HTML içinde tekrar kullanılacak kaçış yardımcı fonksiyonu
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Tarayıcıya eski içerik gönderilmesini engelleyen önbellek başlıkları
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Hatalı girişte kullanıcıyı login sayfasına hata mesajıyla yönlendirir
function redirectToLoginWithError($message, $mail = '')
{
    setcookie('auth', '', time() - 3600, '/');

    $query = '?error=' . urlencode($message);
    if ($mail !== '') {
        $query .= '&mail=' . urlencode($mail);
    }

    header('Location: login.html' . $query);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

// Formdan gelen kullanıcı bilgileri okunur ve doğrulanır
$enteredMail = trim((string) ($_POST['ogrenci_mail'] ?? ''));
$enteredStudentNo = trim((string) ($_POST['ogrenci_no'] ?? ''));

if ($enteredMail === '' || $enteredStudentNo === '') {
    redirectToLoginWithError('Kullanici adi ve sifre alanlari bos birakilamaz.', $enteredMail);
}

$studentNo = 'b251210573';
$studentMail = $studentNo . '@sakarya.edu.tr';

// Öğrenci numarası ve e-posta eşleşmesi kontrol edilir
if (strtolower($enteredMail) !== strtolower($studentMail) || $enteredStudentNo !== $studentNo) {
    redirectToLoginWithError('Kullanici adi veya sifre hatali.', $enteredMail);
}

// Başarılı girişte oturum çerezi ayarlanır
setcookie('auth', '1', time() + 3600, '/');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Başarılı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="result-page">
    <header>
        <!-- Başarılı giriş sayfasının üst menüsü -->
        <nav class="navbar navbar-expand-lg site-navbar">
            <div class="container-fluid px-3 px-lg-4">
                <span class="navbar-brand logo mb-0">Web Sayfam</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                        aria-controls="mainNavbar" aria-expanded="false" aria-label="Menüyü aç">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                        <li class="nav-item"><a class="nav-link" href="index.html">Hakkımda</a></li>
                        <li class="nav-item"><a class="nav-link" href="cv.html">Özgeçmiş</a></li>
                        <li class="nav-item"><a class="nav-link" href="sehir.html">Şehrim</a></li>
                        <li class="nav-item"><a class="nav-link" href="miras.html">Miras</a></li>
                        <li class="nav-item"><a class="nav-link" href="ilgi.html">İlgi Alanlarım</a></li>
                        <li class="nav-item"><a class="nav-link" href="iletisim.html">İletişim</a></li>
                        <li class="nav-item"><a class="nav-link active" href="login.html">Giriş</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container result-main">
        <!-- Giriş sonucu ve yönlendirme seçenekleri -->
        <section class="result-card">
            <div class="result-hero">
                <span class="result-chip">Giriş Durumu</span>
                <h1>Hoşgeldiniz <?php echo e($studentNo); ?></h1>
                <p>Kimlik doğrulama başarılı. Sisteme güvenli şekilde giriş yaptınız.</p>
            </div>
            <div class="result-actions">
                <a href="index.html" class="result-btn">Ana Sayfaya Git</a>
                <a href="login.html" class="result-btn result-btn-secondary">Farklı Hesapla Giriş Yap</a>
            </div>
        </section>
    </main>

    <footer class="site-footer text-center py-4 mt-5">
        <small>© 2025 Arda — Tüm hakları saklıdır.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
