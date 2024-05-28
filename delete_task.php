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

// silinecek görevin id'sini alma
$task_id = $_GET['id'];

// görevi veritabanından silme 
$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
if ($stmt->execute([$task_id])) {
	// başarılı bir şekilde silindiyse, kullanıcıyı görev listesine yönlendirme
	header("Location: list_tasks.php?project_id=" . $_GET['project_id']);
} else {
	// silme işlemi başarısız olursa hata mesajı gösterme
	echo "Görev silme başarısız!";
}
?>