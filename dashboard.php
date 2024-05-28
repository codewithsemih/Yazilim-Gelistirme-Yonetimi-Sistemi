<?php
//veritabanı entegresi
require 'config.php';

// oturumu açma
session_start();

// Kullanıcı oturumu kontrolü
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit;
}

// oturum açmış kullanıcının ID'sini alma
$user_id = $_SESSION['user_id'];

// kullanıcının sahip olduğu projeleri veritabanından alma
$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ?");
$stmt->execute([$user_id]);
$projects = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Bilgilendirme Ekranı</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	</head>

	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container">
				<!-- navbar menüsü -->
				<a class="navbar-brand" href="index.php">Yazılım Geliştirme Yönetimi Sistemi</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
					aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav ml-auto">
						<!-- giriş yapan kullanıcının adını görüntüleme -->
						<?php if (isset($_SESSION['username'])): ?>
							<li class="nav-item">
								<span class="navbar-text">Hoş geldiniz,
									<?php echo htmlspecialchars($_SESSION['username']); ?></span>
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
			<!-- başlık -->
			<h1 class="mt-5 text-center">Bilgilendirme Ekranı</h1>
			<div class="d-flex justify-content-between">
				<!-- yeni proje ekleme butonu -->
				<h2>Projeler</h2>
				<a href="add_project.php" class="btn btn-outline-dark">Yeni Proje Ekle</a>
			</div>
			<?php if ($projects): ?>
				<!-- kullanıcının sahip olduğu projelerin listesi -->
				<table class="table table-bordered mt-3">
					<thead>
						<tr>
							<th>ID</th>
							<th>Başlık</th>
							<th>Açıklama</th>
							<th>Oluşturulma Tarihi</th>
							<th>İşlemler</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($projects as $project): ?>
							<tr>
								<!-- proje bilgilerini tabloya ekleme -->
								<td><?= htmlspecialchars($project['id']) ?></td>
								<td><?= htmlspecialchars($project['title']) ?></td>
								<td><?= htmlspecialchars($project['description']) ?></td>
								<td><?= htmlspecialchars($project['created_at']) ?></td>
								<td>
									<!-- proje düzenleme, silme ve görevlere gitme bağlantıları -->
									<a href="edit_project.php?id=<?= $project['id'] ?>"
										class="btn btn-warning btn-sm">Düzenle</a>
									<a href="delete_project.php?id=<?= $project['id'] ?>" class="btn btn-danger btn-sm"
										onclick="return confirm('Bu projeyi silmek istediğinize emin misiniz?')">Sil</a>
									<a href="list_tasks.php?project_id=<?= $project['id'] ?>" class="btn btn-info btn-sm">Proje
										Görevleri</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else: ?>
				<!-- kullanıcının henüz proje eklememiş olması durumu -->
				<p>Henüz eklenmiş bir proje yok.</p>
			<?php endif; ?>
		</div>
	</body>

</html>