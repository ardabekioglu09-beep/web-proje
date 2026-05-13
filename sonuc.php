<?php
// HTML için güvenli metin üretir
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Boş alanları ve dizileri okunabilir biçimde gösterir
function displayValue($value)
{
    if (is_array($value)) {
        return e(implode(', ', $value));
    }

    if ($value === '' || $value === null) {
        return 'Belirtilmedi';
    }

    return nl2br(e($value));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Form dışı erişimde kullanıcıyı iletişim sayfasına yönlendiren basit fallback
    echo '<!DOCTYPE html><html lang="tr"><head><meta charset="UTF-8"><title>Sonuc</title></head><body>';
    echo '<h2>Bu sayfa sadece form gonderimi ile acilmalidir.</h2>';
    echo '<p><a href="iletisim.html">Iletisim formuna don</a></p>';
    echo '</body></html>';
    exit; // POST yoksa devam etme
}

$fields = [
    'ad' => 'Ad',
    'soyad' => 'Soyad',
    'email' => 'E-posta',
    'telefon' => 'Telefon',
    'dogumTarihi' => 'Doğum Tarihi',
    'sehir' => 'Şehir',
    'cinsiyet' => 'Cinsiyet',
    'yasGrubu' => 'Yaş Grubu',
    'iletisimTercihi' => 'İletişim Tercihi',
    'mesajTuru' => 'Mesaj Türü',
    'memnuniyet' => 'Memnuniyet Puanı',
    'konu' => 'Konu',
    'mesaj' => 'Mesaj',
    'kosullar' => 'Kullanım Koşulları',
];

// Yüklenen dosyanın özet bilgisi hazırlanır
$uploadedFileInfo = 'Yüklenen dosya yok.'; // Varsayılan dosya durumu
if (isset($_FILES['dosya']) && $_FILES['dosya']['error'] === UPLOAD_ERR_OK) {
    $uploadedFileInfo = 'Dosya Adı: ' . e($_FILES['dosya']['name'])
        . ' | Boyut: ' . e((string) $_FILES['dosya']['size']) . ' byte'
        . ' | Tür: ' . e($_FILES['dosya']['type']);
}

$hasUploadedFile = isset($_FILES['dosya']) && $_FILES['dosya']['error'] === UPLOAD_ERR_OK; // CSS durum sınıfı için
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim Sonucu | Arda Portfolio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="result-page">
    <header>
        <!-- Sonuç sayfası için ortak üst menü -->
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
                        <li class="nav-item"><a class="nav-link active" href="iletisim.html">İletişim</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container result-main">
        <!-- Form verilerini özetleyen sonuç kartı -->
        <section class="result-card">
            <div class="result-hero">
                <span class="result-chip">Mesaj Durumu</span>
                <h1>Teşekkürler, mesajın başarıyla alındı.</h1>
                <p>Formdan gönderdiğin bilgiler aşağıda düzenli şekilde listeleniyor. İstersen geri dönüp yeni bir mesaj daha bırakabilirsin.</p>
            </div>

            <h2>Gönderilen Form Bilgileri</h2>

            <!-- Gönderilen alanların tablo görünümü -->
            <div class="result-table-wrap">
                <table class="result-table">
                    <tbody>
                        <?php foreach ($fields as $key => $label): ?>
                            <tr>
                                <th><?php echo e($label); ?></th>
                                <td>
                                    <?php
                                    if ($key === 'kosullar') {
                                        echo isset($_POST[$key]) ? 'Kabul edildi' : 'Kabul edilmedi'; // Checkbox metni
                                    } else {
                                        echo displayValue($_POST[$key] ?? ''); // Alan değerini güvenli yazdır
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Dosya yükleme durumu ayrıca gösterilir -->
            <div class="upload-card<?php echo $hasUploadedFile ? ' upload-card-success' : ''; ?>">
                <strong>Dosya Bilgisi</strong>
                <p class="mb-0"><?php echo $uploadedFileInfo; ?></p>
            </div>

            <!-- İletişim sayfasına veya ana sayfaya dönüş seçenekleri -->
            <div class="result-actions">
                <a href="iletisim.html" class="result-btn">İletişim Formuna Geri Dön</a>
                <a href="index.html" class="result-btn result-btn-secondary">Ana Sayfaya Git</a>
            </div>
        </section>
    </main>

    <footer class="site-footer text-center py-4 mt-5">
        <small>© 2025 Arda — Tüm hakları saklıdır.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
