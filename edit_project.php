<?php
// veritabanı entegresi
require 'config.php';

// oturum açma	
session_start();

// kullanıcı oturum açmış mı kontrol etme
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit;
}

// proje id'si alma
$project_id = $_GET['id'];

// eğer form gönderilmişse
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Formdan gelen verileri alma
	$title = $_POST['title'];
	$description = $_POST['description'];

	// proje bilgilerini güncellemek için veritabanını sorgulama
	$stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ? WHERE id = ?");
	if ($stmt->execute([$title, $description, $project_id])) {
		// başarılı bir şekilde güncellendiyse, kullanıcıyı projeler listesine yönlendirme
		header("Location: list_projects.php");
	} else {
		echo "Proje düzenleme başarısız!";
	}
} else {
	// eğer form gönderilmemişse, mevcut projeyi veritabanından alma
	$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
	$stmt->execute([$project_id]);
	$project = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="tr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Proje Düzenle</title>
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
			<h1 class="mt-5">Proje Düzenle</h1>
			<!-- proje düzenleme formu -->
			<form action="edit_project.php?id=<?= htmlspecialchars($project_id) ?>" method="post">
				<div class="form-group">
					<label for="title">Başlık</label>
					<input type="text" class="form-control" id="title" name="title"
						value="<?= htmlspecialchars($project['title']) ?>" required>
				</div>
				<div class="form-group">
					<label for="description">Açıklama</label>
					<textarea class="form-control" id="description"
						name="description"><?= htmlspecialchars($project['description']) ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Güncelle</button>
			</form>
		</div>
	</body>

</html>