<?php 
session_start();
require 'include/function.php';

// cek apakah ada session
if (!isset($_SESSION['login'])) {
	header("Location: login.php");
}

$nama = '';
$nip = '';
$nidn = '';
$jk = '';

if (isset($_POST['btn-tambah'])) {
	
	$data = $_POST;
	$namadivisi = htmlspecialchars($data['nama']);
	$nip = htmlspecialchars($data['nip']);
	$nidn = htmlspecialchars($data['nidn']);
	$jk = htmlspecialchars($data['jk']);

	// cek apakah ada NIP atau NIDN yang sama
	$query = "SELECT * FROM divisi WHERE nip='$nip' OR nidn='$nidn'";
	$result = $conn->query($query);

	// jika tidak ada, insert data
	if ($result->rowcount() == 0) {

		$pst = $conn->prepare("INSERT INTO divisi VALUES ('', :namadivisi, :nip, :nidn, :jk, 'on')");
		$pst->bindParam(':namadivisi', $namadivisi);
		$pst->bindParam(':nip', $nip);
		$pst->bindParam(':nidn', $nidn);
		$pst->bindParam(':jk', $jk);

		if ($pst->execute()) {
			echo "
			<script>
				alert('data berhasil diinsert!');
				document.location.href = 'divisi.php';
			</script>
			";
		} else {
			echo "
			<script>
				alert('data gagal diinsert!');
				document.location.href = 'tambahdivisi.php';
			</script>
			";
		}
	} else {

		global $nip;
		global $nidn;

		// cek apakah NIP atau NIDN yang sama
		$query = "SELECT * FROM divisi WHERE nip='$nip'";
		$result = $conn->query($query);

		// jika NIP sudah ada
		if ($result->rowcount() > 0) {
			$nipinvalid = true;
		}

		$query = "SELECT * FROM divisi WHERE nidn='$nidn'";
		$result = $conn->query($query);

		// jika NIDN sudah ada
		if ($result->rowcount() > 0) {
			$nidninvalid = true;
		}

		$nama = $_POST['nama'];
		$nip = $_POST['nip'];
		$nidn = $_POST['nidn'];
		$jk = $_POST['jk'];

	}	
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Halaman divisi</title>
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
				<h2 class="datatruk">Tambah Data divisi</h2>
				
				<form action="" method="post">

					<div class="input">
						
						<div class="input-group">
							<label for="nama">Nama Divisi</label>
							<input type="text" name="nama" id="nama" required autocomplete="off" value="<?= $nama; ?>">
						</div>

						<div class="input-group">
							<label for="nip">NIP</label>
							<input type="text" name="nip" id="nip" required autocomplete="off" value="<?= $nip; ?>">
							<?php if (isset($nipinvalid)) : ?>
								<label class="tahun-invalid">NIP sudah ada!</label>
							<?php endif; ?>
						</div>

						<div class="input-group">
							<label for="nidn">NIDN</label>
							<input type="text" name="nidn" id="nidn" required autocomplete="off" value="<?= $nidn; ?>">
							<?php if (isset($nidninvalid)) : ?>
								<label class="tahun-invalid">NIDN sudah ada!</label>
							<?php endif; ?>
						</div>
						
						<div class="input-group radio-btn">
							<label>Jenis Roda</label>
							<div class="radio-wrapper">
								<input type="radio" name="jk" value="Roda4" id="laki" class="radio" <?= ($jk == 'Roda4' || $jk == '') ? 'checked' : '' ?>><label for="laki">Roda 4</label>
								<input type="radio" name="jk" value="Roda6" id="Roda6" class="radio" <?= ($jk == 'Roda6') ? 'checked' : '' ?>> <label for="Roda6">Roda 6</label>
							</div>
						</div>
						
						<button type="submit" name="btn-tambah">Tambah Data</button>

					</div>
							
				</form>

			</article>

		</main>
	</div>
	
</body>
</html>