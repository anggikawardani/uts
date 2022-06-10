<?php 
session_start();
require 'include/function.php';

// cek apakah ada session
if (!isset($_SESSION['login'])) {
	header("Location: login.php");
}

// ambil id yang dikirim
$id_divisi = $_GET['id'];

// ambil data divisi sesuai id yang dikirim
$query = "SELECT * FROM divisi WHERE id_divisi=$id_divisi";
$result = $conn->query($query);
$data = $result->fetch();

// menentukan radio button yang checked
if ($data['jk'] == "Roda4") {
	$laki = true;
}

// cek apakah tombol ubah data ditekan
if (isset($_POST['btn-ubah'])) {

	// pindahkan data dari $_POST ke variabel
	$data = $_POST;
	$namadivisi = htmlspecialchars($data['nama']);
	$nip = htmlspecialchars($data['nip']);
	$nidn = htmlspecialchars($data['nidn']);
	$jk = htmlspecialchars($data['jk']);

	// prepare sql dan bind parameters
	$pst = $conn->prepare("UPDATE divisi SET nama_divisi=:nama_divisi, nip=:nip, nidn=:nidn, jk=:jk WHERE id_divisi=:id_divisi");
	$pst->bindParam(':nama_divisi', $namadivisi);
	$pst->bindParam(':nip', $nip);
	$pst->bindParam(':nidn', $nidn);
	$pst->bindParam(':jk', $jk);
	$pst->bindParam(':id_divisi', $id_divisi);

	// execute query
	if ($pst->execute()) {
		echo "
		<script>
			alert('data berhasil diupdate!');
			document.location.href = 'divisi.php';
		</script>
		";
	} else {
		echo "
		<script>
			alert('data gagal diupdate!');
			document.location.href = 'ubahdivisi.php';
		</script>
		";
	}
}




?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Halaman Divisi</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<div class="container">
		<header>
			<h2>Sistem Informasi Truk PT. Florindo</h2>
			<div class="profil">
				<p><?= $_SESSION['nama']; ?></p>
				<img src="assets/img/prof2.png" alt="foto-profil">
			</div>
		</header>

		<main>

			<nav>
				<div class="truk">
					<a href="index.php">Truk</a>
				</div>
				<div class="muatan active">
					<a href="muatan.php">Muatan</a>
				</div>
				<div class="divisi">
					<a href="divisi.php">Divisi</a>
				</div>
				<div class="logout">
					<a href="logout.php">Keluar</a>
				</div>
			</nav>

			<article class="article">
				<h2 class="datatruk">Ubah Data divisi</h2>
				
				<form action="" method="post">

					<div class="input">
						
						<div class="input-group">
							<label for="nama">Nama divisi</label>
							<input type="text" name="nama" id="nama" required autocomplete="off" value="<?= $data['nama_divisi']; ?>">
						</div>

						<div class="input-group">
							<label for="nip">NIP</label>
							<input type="text" name="nip" id="nip" required autocomplete="off" value="<?= $data['nip']; ?>">
						</div>

						<div class="input-group">
							<label for="nidn">NIDN</label>
							<input type="text" name="nidn" id="nidn" required autocomplete="off" value="<?= $data['nidn']; ?>">
						</div>
						
						<div class="input-group radio-btn">
							<label>Jenis Roda</label>
							<div class="radio-wrapper">
								<input type="radio" name="jk" value="Roda4" id="laki" class="radio" <?= (isset($laki)) ? 'checked' : '' ?>>
								<label for="laki">Roda 4</label>
								<input type="radio" name="jk" value="Roda6" id="Roda6" class="radio" <?= (isset($laki)) ? '' : 'checked' ?>> 
								<label for="Roda6">Roda 6</label>
							</div>
						</div>
						
						<button type="submit" name="btn-ubah">Ubah Data</button>

					</div>
							
				</form>

			</article>

		</main>
	</div>
	
</body>
</html>