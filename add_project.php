<?php
// veritabanı entegresi
require 'config.php';

// oturum açma
session_start();

// kullanıcı oturumu kontrolü
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit;
}

// form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// formdan gelen verileri alma
	$title = $_POST['title'];
	$description = $_POST['description'];
	$user_id = $_SESSION['user_id'];

	// Veritabanına proje ekleme sorgulama
	$stmt = $pdo->prepare("INSERT INTO projects (user_id, title, description) VALUES (?, ?, ?)");
	if ($stmt->execute([$user_id, $title, $description])) {
		// başarılı ise projeler listesine yönlendirme
		header("Location: list_projects.php");
	} else {
		// başarısız durumda hata mesajı gösterme
		echo "Proje ekleme başarısız!";
	}
}
?>
<!DOCTYPE html>
<html lang="tr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Proje Ekle</title>
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
			<h1 class="mt-5">Proje Ekle</h1>
			<!-- proje ekleme formu -->
			<form action="add_project.php" method="post">
				<div class="form-group">
					<label for="title">Başlık</label>
					<input type="text" class="form-control" id="title" name="title" required>
				</div>
				<div class="form-group">
					<label for="description">Açıklama</label>
					<textarea class="form-control" id="description" name="description"></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Ekle</button>
			</form>
		</div>
	</body>

</html>