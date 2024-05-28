<?php
// veritabanı entegresi
require 'config.php';

// oturumu açma
session_start();

// Eğer form gönderimi POST metoduyla yapılmışsa:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Kullanıcı adı ve şifre değişkenlerini POST isteğiyle alma
	$username = $_POST['username'];
	$password = $_POST['password'];

	// Veritabanından kullanıcıyı kullanıcı adına göre sorgulama
	$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
	$stmt->execute([$username]);
	$user = $stmt->fetch();

	// Kullanıcı bulundu ve şifre doğruysa oturum değişkenlerini ayarla ve kullanıcıyı yönlendir
	if ($user && password_verify($password, $user['password'])) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['username'] = $user['username']; // Kullanıcı adını sakla
		header("Location: dashboard.php");
	} else {
		// Hatalı giriş durumunda kullanıcıyı uyar
		echo "<script type='text/javascript'>alert('Geçersiz kullanıcı adı veya şifre');</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="tr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Giriş Yap</title>
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
			<h1 class="mt-5">Giriş Yap</h1>
			<!-- giriş yapma formu -->
			<form action="login.php" method="post">
				<div class="form-group">
					<label for="username">Kullanıcı Adı</label>
					<input type="text" class="form-control" id="username" name="username" required>
				</div>
				<div class="form-group">
					<label for="password">Şifre</label>
					<input type="password" class="form-control" id="password" name="password" required>
				</div>
				<!-- giriş yapma butonu -->
				<button type="submit" class="btn btn-dark">Giriş Yap</button>
			</form>
		</div>
	</body>

</html>