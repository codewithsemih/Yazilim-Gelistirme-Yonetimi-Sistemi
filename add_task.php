<?php
//veritabanı entegresi
require 'config.php';

// oturumu açma
session_start();

// kullanıcı oturumu kontrolü
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit;
}

// mevcut kullanıcıları veritabanından alma
$stmt = $pdo->prepare("SELECT id, username FROM users");
$stmt->execute();
$users = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// formdan gelen verileri alma
	$title = $_POST['title'];
	$description = $_POST['description'];
	$project_id = $_POST['project_id'];
	$assigned_user_id = $_POST['assigned_user_id'];

	// görev ekleme sorgulama
	$stmt = $pdo->prepare("INSERT INTO tasks (project_id, title, description, assigned_user_id) VALUES (?, ?, ?, ?)");
	if ($stmt->execute([$project_id, $title, $description, $assigned_user_id])) {
		// görev eklendikten sonra ilgili projenin görev listesine yönlendirme
		header("Location: list_tasks.php?project_id=" . $project_id);
		exit;
	} else {
		echo "Görev ekleme başarısız!";
	}
}
?>
<!DOCTYPE html>
<html lang="tr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Görev Ekle</title>
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
			<!-- başlık -->
			<h1 class="mt-5">Görev Ekle</h1>
			<form action="add_task.php" method="post">
				<!-- gizli alan ile proje id'sini formda saklama -->
				<input type="hidden" name="project_id" value="<?= htmlspecialchars($_GET['project_id']) ?>">
				<div class="form-group">
					<label for="title">Başlık</label>
					<input type="text" class="form-control" id="title" name="title" required>
				</div>
				<div class="form-group">
					<label for="description">Açıklama</label>
					<textarea class="form-control" id="description" name="description"></textarea>
				</div>
				<div class="form-group">
					<label for="assigned_user_id">Kullanıcı Ata</label>
					<!-- kullanıcıları açılır listeden seçme -->
					<select class="form-control" id="assigned_user_id" name="assigned_user_id" required>
						<?php foreach ($users as $user): ?>
							<option value="<?= htmlspecialchars($user['id']) ?>"><?= htmlspecialchars($user['username']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<button type="submit" class="btn btn-primary">Ekle</button>
			</form>
		</div>
	</body>

</html>