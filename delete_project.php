<?php
// veritabanı entegresi
require 'config.php';

// oturumu açma
session_start();

// kullanıcı oturum açmış mı kontrol etme
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit;
}

// silinecek proje id'sini alma
$project_id = $_GET['id'];

// proje veritabanından silme
$stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
if ($stmt->execute([$project_id])) {
	// başarılı bir şekilde silindiyse, kullanıcıyı proje listesine yönlendirme
	header("Location: list_projects.php");
} else {
	// silme işlemi başarısız olursa hata mesajı gösterme
	echo "Proje silme başarısız!";
}
?>