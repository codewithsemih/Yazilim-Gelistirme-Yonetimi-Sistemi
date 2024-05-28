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

// proje id'si GET parametresi almış mı kontrol etme
if (!isset($_GET['project_id'])) {
	header("Location: list_projects.php");
	exit;
}

// proje id alma
$project_id = $_GET['project_id'];

// veritabanından proje görevlerini sorgulama ve kullanıcı bilgilerini getirme
$stmt = $pdo->prepare("SELECT tasks.*, users.username as assigned_username FROM tasks LEFT JOIN users ON tasks.assigned_user_id = users.id WHERE project_id = ?");
$stmt->execute([$project_id]);
$tasks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Görevler</title>
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
							<li class="nav-item">
								<!-- giriş yapan kullanıcının adını görüntüleme -->
								<span class="navbar-text">Hoş geldiniz,
									<?php echo htmlspecialchars($_SESSION['username']); ?></span>
							</li>
							<li class="nav-item">
								<!-- bilgilendirme ekranı butonu -->
								<a class="nav-link" href="dashboard.php">Bilgilendirme Ekranı</a>
							</li>
							<li class="nav-item">
								<!-- çıkış yapma butonu -->
								<a class="nav-link" href="logout.php">Çıkış Yap</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
			<!-- Başlık -->
			<h1 class="mt-5 text-center">Görevler</h1>
			<div class="d-flex justify-content-end">
				<!-- yeni görev ekleme butonu -->
				<a href="add_task.php?project_id=<?= htmlspecialchars($project_id) ?>" class="btn btn-outline-dark">Yeni
					Görev Ekle</a>
			</div>
			<br>
			<!-- görevlerin listesi -->
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th>Başlık</th>
						<th>Açıklama</th>
						<th>Atanan Kullanıcı</th>
						<th>Durum</th>
						<th>Oluşturulma Tarihi</th>
						<th>İşlemler</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($tasks as $task): ?>
						<tr>
							<td><?= htmlspecialchars($task['id']) ?></td>
							<td><?= htmlspecialchars($task['title']) ?></td>
							<td><?= htmlspecialchars($task['description']) ?></td>
							<td><?= htmlspecialchars($task['assigned_username']) ?></td>
							<td><?= htmlspecialchars($task['status']) ?></td>
							<td><?= htmlspecialchars($task['created_at']) ?></td>
							<td>
								<!-- görevi düzenleme ve silme butonları -->
								<a href="edit_task.php?id=<?= $task['id'] ?>&project_id=<?= $project_id ?>"
									class="btn btn-warning btn-sm">Düzenle</a>
								<a href="delete_task.php?id=<?= $task['id'] ?>&project_id=<?= $project_id ?>"
									class="btn btn-danger btn-sm"
									onclick="return confirm('Bu görevi silmek istediğinize emin misiniz?')">Sil</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</body>

</html>