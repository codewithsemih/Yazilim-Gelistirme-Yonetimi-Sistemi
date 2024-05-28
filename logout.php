<?php
// oturumu başlatma
session_start();

// oturumu temizleme ve sonlandırma
session_unset();
session_destroy();

// ana sayfaya yönlendirme
header("Location: index.php");
exit;
?>