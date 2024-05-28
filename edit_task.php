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

// görev id'si alma
$task_id = $_GET['id'];

// mevcut kullanıcıları veritabanından alma
$stmt = $pdo->prepare("SELECT id, username FROM users");
$stmt->execute();
$users = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Form gönderilmişse, form verilerini alma
	$title = $_POST['title'];
	$description = $_POST['description'];
	$status = $_POST['status'];
	$assigned_user_id = $_POST['assigned_user_id'];

	// görevi güncellemek için veritabanına sorgulama
	$stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, status = ?, assigned_user_id = ? WHERE id = ?");
	if ($stmt->execute([$title, $description, $status, $assigned_user_id, $task_id])) {
		// başarılı bir şekilde güncellendiyse, kullanıcıyı görevler listesine yönlendirme
		header("Location: list_tasks.php?project_id=" . $_GET['project_id']);
	} else {
		echo "Görev düzenleme başarısız!";
	}
} else {
	// eğer form gönderilmediyse, mevcut görevi veritabanından alma
	$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
	$stmt->execute([$task_id]);
	$task = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="tr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Görev Düzenle</title>
		<!-- Bootstrap entegre etme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	</head>

	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container">
				<!-- navbarda program adı -->
				<a class="navbar-brand" href="index.php">Yazılım Geliştirme Yönetimi Sistemi</a>
				<!-- program adına tıklanınca ana sayfaya dönme butonu -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
					aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<!-- navbar menüsü -->
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav ml-auto">
						<?php if (isset($_SESSION['username'])): ?>
							<!-- giriş yapan kullanıcının adını görüntüleme -->
							<li class="nav-item">
								<span class="navbar-text">Hoş geldiniz,
									<?php echo htmlspecialchars($_SESSION['username']); ?></span>
							</li>
							<!-- bilgilendirme ekranı butonu -->
							<li class="nav-item">
								<a class="nav-link" href="dashboard.php">Bilgilendirme Ekranı</a>
							</li>
							<!-- çıkış yapma butonu -->
							<li class="nav-item">
								<a class="nav-link" href="logout.php">Çıkış Yap</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
			<!-- Başlık -->
			<h1 class="mt-5">Görev Düzenle</h1>
			<!-- görev düzenleme formu -->
			<form
				action="edit_task.php?id=<?= htmlspecialchars($task_id) ?>&project_id=<?= htmlspecialchars($_GET['project_id']) ?>"
				method="post">
				<div class="form-group">
					<label for="title">Başlık</label>
					<input type="text" class="form-control" id="title" name="title"
						value="<?= htmlspecialchars($task['title']) ?>" required>
				</div>
				<div class="form-group">
					<label for="description">Açıklama</label>
					<textarea class="form-control" id="description"
						name="description"><?= htmlspecialchars($task['description']) ?></textarea>
				</div>
				<div class="form-group">
					<label for="status">Durum</label>
					<select class="form-control" id="status" name="status">
						<!-- görevin durumunu seçme -->
						<option value="pending" <?= $task['status'] == 'pending' ? 'selected' : '' ?>>Beklemede</option>
						<option value="in_progress" <?= $task['status'] == 'in_progress' ? 'selected' : '' ?>>Devam Ediyor
						</option>
						<option value="completed" <?= $task['status'] == 'completed' ? 'selected' : '' ?>>Tamamlandı
						</option>
					</select>
					</