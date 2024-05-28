<?php
// veritabanı entegresi
require 'config.php';

// Eğer form gönderimi POST metoduyla yapılmışsa:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Kullanıcı adı ve şifre değişkenlerini POST isteğiyle alma
	$username = $_POST['username'];
	// Şifreyi güvenli bir şekilde hash'leme
	$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

	// Kullanıcı bilgilerini veritabanına ekleme
	$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
	// eğer doğru ise giriş yapma ekranına yönlendirme
	if ($stmt->execute([$username, $password])) {
		header("Location: login.php");
	} else {
		// Ekleme başarısızsa hata verme
		echo "Kullanıcı kaydı başarısız!";
	}
}
?>
<!DOCTYPE html>
<html lang="tr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Kayıt Ol</title>
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
						<li class="nav-item">
							<!-- ana sayfa butonu -->
							<a class="nav-link" href="index.php">Ana Sayfa</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
			<!-- Başlık -->
			<h1 class="mt-5">Kayıt Ol</h1>
			<!-- kayıt olma formu -->
			<form action="register.php" method="post">
				<div class="form-group">
					<label for="username">Kullanıcı Adı</label>
					<input type="text" class="form-control" id="username" name="username" required>
				</div>
				<div class="form-group">
					<label for="password">Şifre</label>
					<input type="password" class="form-control" id="password" name="password" required>
				</div>
				<!-- kayıt olma butonu -->
				<button type="submit" class="btn btn-dark">Kayıt Ol</button>
			</form>
		</div>
	</body>

</html>