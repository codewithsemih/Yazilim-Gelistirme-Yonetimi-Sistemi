<?php
$host = 'localhost'; // veritabanı sunucusu
$db = 'ygys_veritabani'; // veritabanı adı
$user = 'root'; // veritabanı kullanıcı adı
$pass = ''; // veritabanı şifresi

try {
	// PDO nesnesi oluşturarak veritabanına bağlanma
	$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
	// Hata ayıklama modunu etkinleştirme
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	// Bağlantı hatası oluşursa hata mesajını görüntüleme
	die("Bağlantı hatası: " . $e->getMessage());
}
?>